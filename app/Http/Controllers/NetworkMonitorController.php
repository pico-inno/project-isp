<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SNMP;

class NetworkMonitorController extends Controller
{

    public function getDeviceHostname($ipAddress, $community) {
        // Verify PHP SNMP
        if (!function_exists('snmpget')) {
            return ['error' => 'PHP SNMP extension missing'];
        }

        // Test raw socket connection first
        $socket = @fsockopen("udp://$ipAddress", 161, $errno, $errstr, 1);
        if (!$socket) {
            return [
                'error' => 'UDP connection failed',
                'details' => "$errstr (Code $errno)",
                'debug' => [
                    'ip' => $ipAddress,
                    'php_version' => phpversion(),
                    'extensions' => get_loaded_extensions()
                ]
            ];
        }
        fclose($socket);

        // Try different OID formats
        $oids = [
            'numeric' => '.1.3.6.1.2.1.1.5.0',
            'textual' => 'SNMPv2-MIB::sysName.0'
        ];

        foreach ($oids as $type => $oid) {
            $result = @snmpget($ipAddress, $community, $oid, 1000000, 1);
            if ($result !== false) {
                return [
                    'success' => trim($result, '"'),
                    'used_oid' => $oid
                ];
            }
        }

        return [
            'error' => 'All SNMP attempts failed',
            'last_error' => error_get_last()
        ];
    }



    /**
     * Retrieves interface details, including RX/TX octets, from a network device using SNMP.
     *
     * @param string $ipAddress The IP address of the network device.
     * @param string $community The SNMP community string.
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInterfaceDetails($ipAddress, $community)
    {
        try {
            // Set the SNMP version to 2c
            snmp_set_quick_print(true);
            snmp_set_oid_output_format(SNMP_OID_OUTPUT_NUMERIC);

            // OIDs for interface details
            $oids = [
                'ifDescr' => '.1.3.6.1.2.1.2.2.1.2',        // Interface Description
                'ifAdminStatus' => '.1.3.6.1.2.1.2.2.1.7',   // Interface Admin Status
                'ifOperStatus' => '.1.3.6.1.2.1.2.2.1.8',    // Interface Operational Status
                'ifInOctets' => '.1.3.6.1.2.1.2.2.1.10',    // Bytes received on the interface
                'ifOutOctets' => '.1.3.6.1.2.1.2.2.1.16',   // Bytes transmitted on the interface
            ];

            // Create a new SNMP session
            $session = new \SNMP(\SNMP::VERSION_2C, $ipAddress, $community);

            // Fetch the interface descriptions
            $ifDescriptions = $session->walk($oids['ifDescr']);

            // Fetch the admin and operational statuses
            $ifAdminStatuses = $session->walk($oids['ifAdminStatus']);
            $ifOperStatuses = $session->walk($oids['ifOperStatus']);

            // Fetch the InOctets and OutOctets
            $ifInOctets = $session->walk($oids['ifInOctets']);
            $ifOutOctets = $session->walk($oids['ifOutOctets']);

            // Close the SNMP session
            $session->close();

            // Combine the results into a structured array
            $interfaces = [];

            foreach ($ifDescriptions as $fullOid => $description) {
                $parts = explode('.', $fullOid);
                $instanceIdentifier = '.' . end($parts); // e.g., ".1", ".2"

                // Construct the full OID for admin, operational status, and octets for this instance
                $adminStatusOid = $oids['ifAdminStatus'] . $instanceIdentifier;
                $operStatusOid = $oids['ifOperStatus'] . $instanceIdentifier;
                $inOctetsOid = $oids['ifInOctets'] . $instanceIdentifier;
                $outOctetsOid = $oids['ifOutOctets'] . $instanceIdentifier;

                // Safely retrieve values, defaulting to 'Unknown' or 0 if not found
                $adminStatus = isset($ifAdminStatuses[$adminStatusOid]) ? $this->formatStatus($ifAdminStatuses[$adminStatusOid]) : 'Unknown';
                $operationalStatus = isset($ifOperStatuses[$operStatusOid]) ? $this->formatStatus($ifOperStatuses[$operStatusOid]) : 'Unknown';
                $rxOctets = isset($ifInOctets[$inOctetsOid]) ? (int)$ifInOctets[$inOctetsOid] : 0;
                $txOctets = isset($ifOutOctets[$outOctetsOid]) ? (int)$ifOutOctets[$outOctetsOid] : 0;

                $interfaces[] = [
                    'index' => ltrim($instanceIdentifier, '.'),
                    'description' => $description,
                    'admin_status' => $adminStatus,
                    'operational_status' => $operationalStatus,
                    'rx_octets' => $rxOctets,
                    'tx_octets' => $txOctets,
                ];
            }

            return response()->json($interfaces);

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => 'Could not retrieve interface details. ' . $e->getMessage()], 500);
        }
    }

    /**
     * Helper function to format numeric status to human-readable string.
     *
     * @param int $status The numeric status value (e.g., 1 for up, 2 for down).
     * @return string
     */
    private function formatStatus($status)
    {
        switch ($status) {
            case 1:
                return 'up';
            case 2:
                return 'down';
            case 3:
                return 'testing';
            case 4:
                return 'unknown';
            case 5:
                return 'dormant';
            case 6:
                return 'notPresent';
            case 7:
                return 'lowerLayerDown';
            default:
                return 'unknown';
        }
    }

    /**
     * Get device uptime via SNMP
     * @param string $ipAddress Device IP
     * @param string $community SNMP community string
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDeviceUptime($ipAddress, $community)
    {

        $oids = [
            'hostname' => '.1.3.6.1.2.1.1.5.0',
            'uptime'   => '.1.3.6.1.2.1.1.3.0',
            'contact'  => '.1.3.6.1.2.1.1.4.0',
            'location' => '.1.3.6.1.2.1.1.6.0'
        ];

        $result = [];
        foreach ($oids as $key => $oid) {
            $value = snmpget($ipAddress, $community, $oid);
            $result[$key] = trim($value, '"') ?? null;
        }

        return response()->json($result);
    }


    public function writeSystem($ipAddress, $community, $name)
    {

        $newSystemName = $name;

        try {
            // Set the SNMP version to 2c
            snmp_set_quick_print(true);
            snmp_set_oid_output_format(SNMP_OID_OUTPUT_NUMERIC);

            // OID for System Name
            $sysNameOid = '.1.3.6.1.2.1.1.5.0'; // sysName.0

            // Create a new SNMP session
            $session = new \SNMP(\SNMP::VERSION_2C, $ipAddress, $community);

            // Perform the SNMP SET operation
            // $result will be true on success, false on failure
            $result = $session->set(
                $sysNameOid,    // OID
                's',            // Type: 's' for string
                $newSystemName  // Value
            );

            // Close the SNMP session
            $session->close();

            if ($result) {
                return response()->json(['message' => 'System name updated successfully to: ' . $newSystemName]);
            } else {
                // If set returns false, it usually means an error occurred during the SNMP operation.
                // The snmp library might not provide a detailed error here directly from set().
                // You might need to check router logs or snmpwalk for more info.
                return response()->json(['error' => 'Failed to update system name. Check SNMP write permissions and device connectivity.'], 500);
            }

        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => 'Could not set system name. ' . $e->getMessage()], 500);
        }
    }


    public function executeMikrotikScript($ipAddress, $community, $scriptName)
    {

        $scriptToExecuteName = $scriptName;

        try {
            snmp_set_quick_print(true);
            snmp_set_oid_output_format(SNMP_OID_OUTPUT_NUMERIC);

            $session = new \SNMP(\SNMP::VERSION_2C, $ipAddress, $community);

            // OIDs for MikroTik Scripts MIB
            $scriptNameBaseOid = '.1.3.6.1.4.1.14988.1.1.8.1.1.2'; // mtXmScriptName
            $scriptRunBaseOid = '.1.3.6.1.4.1.14988.1.1.8.1.1.5';  // mtXmScriptRun

            // Step 1: Find the numerical index of the script by its name
            $scriptNames = $session->walk($scriptNameBaseOid);
            $scriptIndex = null;

            foreach ($scriptNames as $fullOid => $name) {
                if ($name == "\"$scriptToExecuteName\"")
                {
                    $parts = explode('.', $fullOid);
                    $scriptIndex = end($parts); // Get the last part, which is the index
                    break;
                }
            }

            if (is_null($scriptIndex)) {
                $session->close();
                return response()->json(['error' => 'Script with name "' . $scriptToExecuteName . '" not found on the MikroTik device.', 'fasd' => $scriptNames], 404);
            }

            // Step 2: Construct the full OID for running this specific script
            $scriptExecuteOid = $scriptRunBaseOid . '.' . $scriptIndex;

            // Step 3: Execute the script by setting its OID to 1
            $result = $session->set(
                $scriptExecuteOid,  // OID to set
                'i',                // Type: 'i' for integer (1 to run)
                1                   // Value: 1 to trigger the script
            );

            $session->close();

            if ($result) {
                return response()->json(['message' => 'Script "' . $scriptToExecuteName . '" executed successfully.', 'fasd' => $scriptNames]);
            } else {
                return response()->json(['error' => 'Failed to execute script "' . $scriptToExecuteName . '". Check SNMP write permissions, script existence, and device connectivity.'], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['error' => 'Error executing script: ' . $e->getMessage()], 500);
        }
    }
    /**
     * Format seconds into human-readable time
     */
    private function formatUptime($seconds)
    {
        $units = [
            'year'   => 31536000,
            'month'  => 2592000,
            'week'   => 604800,
            'day'    => 86400,
            'hour'   => 3600,
            'minute' => 60,
            'second' => 1
        ];

        $parts = [];
        foreach ($units as $name => $divisor) {
            $quot = (int)($seconds / $divisor);
            if ($quot) {
                $parts[] = $quot . ' ' . $name . ($quot > 1 ? 's' : '');
                $seconds -= $quot * $divisor;
            }
        }

        return implode(', ', $parts);
    }
}
