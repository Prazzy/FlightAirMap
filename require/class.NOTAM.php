<?php
require_once(dirname(__FILE__).'/settings.php');
require_once(dirname(__FILE__).'/class.Connection.php');
require_once(dirname(__FILE__).'/class.Common.php');

class NOTAM {
	public $db;
	private $abbr = array(
	                    'A/A' => 'Air-to-air',
	                    'A/G' => 'Air-to-ground',
	                    'AAL' => 'Above Aerodrome Level',
	                    'ABM' => 'Abeam',
	                    'ABN' => 'Aerodrome Beacon',
	                    'ABT' => 'About',
	                    'ABV' => 'Above',
	                    'ACC' => 'Area Control',
	                    'ACFT' => 'Aircraft',
	                    'ACK' => 'Acknowledge',
	                    'ACL' => 'Altimeter Check Location',
	                    'ACN' => 'Aircraft Classification Number',
	                    'ACPT' => 'Accepted',
	                    'ACT' => 'Active',
	                    'AD' => 'Aerodrome',
	                    'ADA' => 'Advisory Area',
	                    'ADC' => 'Aerodrome Chart',
	                    'ADDN' => 'Additional',
	                    'ADJ' => 'Adjacent',
	                    'ADR' => 'Advisory Route',
	                    'ADS' => 'Automatic Dependent Surveillance',
	                    'ADVS' => 'Advisory Service',
	                    'ADZ' => 'Advised',
	                    'AFIL' => 'Flight Plan Filed In The Air',
	                    'AFM' => 'Affirm',
	                    'AFT' => 'After',
	                    'AGA' => 'Aerodromes, Air Routes and Ground Aids',
	                    'AGN' => 'Again',
	                    'ALERFA' => 'Alert Phase',
	                    'ALRS' => 'Alerting Service',
	                    'ALS' => 'Approach Lighting System',
	                    'ALT' => 'Altitude',
	                    'ALTN' => 'Alternate',
	                    'AMA' => 'Area Minimum Altitude',
	                    'ANC' => 'Aeronautical Chart',
	                    'ANCS' => 'Aeronautical Navigation Chart',
	                    'ANS' => 'Answer',
	                    'AOC' => 'Aerodrome Obstacle Chart',
	                    'AP' => 'Airport',
	                    'APCH' => 'Approach',
	                    'APDC' => 'Aircraft Parking/docking Chart',
	                    'APN' => 'Apron',
	                    'APNS' => 'Aprons',
	                    'APP' => 'Approach Control',
	                    'APR' => 'April',
	                    'APRX' => 'Approximately',
	                    'APSG' => 'After Passing',
	                    'APV' => 'Approved',
	                    'ARC' => 'Area Chart',
	                    'ARNG' => 'Arrange',
	                    'ARO' => 'Air Traffic Services Reporting Office',
	                    'ARP' => 'Aerodrome Reference Point',
	                    'ARR' => 'Arriving',
	                    'ARST' => 'Arresting',
	                    'ASC' => 'Ascend To',
	                    'ASDA' => 'Accelerate-Stop Distance Available',
	                    'ASPEEDG' => 'Airspeed Gain',
	                    'ASPEEDL' => 'Airspeed Loss',
	                    'ASPH' => 'Asphalt',
	                    'ATA' => 'Actual Time of Arrival',
	                    'ATD' => 'Actual Time of Departure',
	                    'ATFM' => 'Air Traffic Flow Management',
	                    'ATM' => 'Air Traffic Management',
	                    'ATP' => 'At',
	                    'ATTN' => 'Attention',
	                    'ATZ' => 'Aerodrome Traffic Zone',
	                    'AUG' => 'August',
	                    'AUTH' => 'Authorization',
	                    'AUW' => 'All Up Weight',
	                    'AUX' => 'Auxiliary',
	                    'AVBL' => 'Available',
	                    'AVG' => 'Average',
	                    'AVGAS' => 'Aviation Gasoline',
	                    'AWTA' => 'Advise At What Time Able',
	                    'AWY' => 'Airway',
	                    'AWYS' => 'Airways',
	                    'AZM' => 'Azimuth',
	                    'BA' => 'Braking Action',
	                    'BCN' => 'Beacon',
	                    'BCST' => 'Broadcast',
	                    'BDRY' => 'Boundary',
	                    'BFR' => 'Before',
	                    'BLDG' => 'Building',
	                    'BLO' => 'Below Clouds',
	                    'BLW' => 'Below',
	                    'BRF' => 'Short',
	                    'BRG' => 'Bearing',
	                    'BRKG' => 'Breaking',
	                    'BTL' => 'Between Layers',
	                    'BTN' => 'Between',
	                    'CD' => 'Candela',
	                    'CDN' => 'Coordination',
	                    'CF' => 'Change Frequency To',
	                    'CFM' => 'Confirm',
	                    'CGL' => 'Circling Guidance Light(s)',
	                    'CH' => 'Channel',
	                    'CHG' => 'Changed',
	                    'CIT' => 'Near or Over Large Towns',
	                    'CIV' => 'Civil',
	                    'CK' => 'Check',
	                    'CL' => 'Centre Line',
	                    'CLBR' => 'Calibration',
	                    'CLD' => 'Cloud',
	                    'CLG' => 'Calling',
	                    'CLIMB-OUT' => 'Climb-out Area',
	                    'CLR' => 'Clearance',
	                    'CLRD' => 'Cleared',
	                    'CLSD' => 'Closed',
	                    'CMB' => 'Climb',
	                    'CMPL' => 'Complete',
	                    'CNL' => 'Cancel',
	                    'CNS' => 'Communications, Navigation And Surveillance',
	                    'COM' => 'Communications',
	                    'CONC' => 'Concrete',
	                    'COND' => 'Condition',
	                    'CONS' => 'Continuous',
	                    'CONST' => 'Construction',
	                    'CONT' => 'Continued',
	                    'COOR' => 'Coordination',
	                    'COORD' => 'Coordinates',
	                    'COP' => 'Change-over Point',
	                    'COR' => 'Correction',
	                    'COT' => 'At The Coast',
	                    'COV' => 'Covered',
	                    'CPDLC' => 'Controller-pilot Data Link Communications',
	                    'CPL' => 'Current Flight Plan',
	                    'CRC' => 'Cyclic Redundancy Check',
	                    'CRZ' => 'Cruise',
	                    'CTAM' => 'Climb To And Maintain',
	                    'CTC' => 'Contact',
	                    'CTL' => 'Control',
	                    'CTN' => 'Caution',
	                    'CTR' => 'Control Zone',
	                    'CVR' => 'Cockpit Voice Recorder',
	                    'CW' => 'Continuous Wave',
	                    'CWY' => 'Clearway',
	                    'DA' => 'Decision Altitude',
	                    'DCKG' => 'Docking',
	                    'DCP' => 'Datum Crossing Point',
	                    'DCPC' => 'Direct Controller-pilot Communications',
	                    'DCT' => 'Direct',
	                    'DEC' => 'December',
	                    'DEG' => 'Degrees',
	                    'DEP' => 'Departing',
	                    'DES' => 'Descend',
	                    'DEST' => 'Destination',
	                    'DETRESFA' => 'Distress Phase',
	                    'DEV' => 'Deviating',
	                    'DFDR' => 'Digital Flight Data Recorder',
	                    'DFTI' => 'Distance From Touchdown Indicator',
	                    'DH' => 'Decision Height',
	                    'DIP' => 'Diffuse',
	                    'DIST' => 'Distance',
	                    'DIV' => 'Divert',
	                    'DLA' => 'Delay',
	                    'DLY' => 'Daily',
	                    'DNG' => 'Dangerous',
	                    'DOM' => 'Domestic',
	                    'DPT' => 'Depth',
	                    'DR' => 'Dead Reckoning',
	                    'DRG' => 'During',
	                    'DTAM' => 'Descend To And Maintain',
	                    'DTG' => 'Date-time Group',
	                    'DTHR' => 'Displaced Runway Threshold',
	                    'DTRT' => 'Deteriorating',
	                    'DTW' => 'Dual Tandem Wheels',
	                    'DUPE' => 'This Is A Duplicate Message',
	                    'DUR' => 'Duration',
	                    'DVOR' => 'Doppler VOR',
	                    'DW' => 'Dual Wheels',
	                    'EAT' => 'Expected Approach Time',
	                    'EB' => 'Eastbound',
	                    'EDA' => 'Elevation Differential Area',
	                    'EET' => 'Estimated Elapsed Time',
	                    'EFC' => 'Expect Further Clearance',
	                    'ELBA' => 'Emergency Location Beacon',
	                    'ELEV' => 'Elevation',
	                    'ELR' => 'Extra Long Range',
	                    'EM' => 'Emission',
	                    'EMERG' => 'Emergency',
	                    'END' => 'Stop-end',
	                    'ENE' => 'East-north-east',
	                    'ENG' => 'Engine',
	                    'ENR' => 'En-route',
	                    'ENRC' => 'En-route Chart',
	                    'EOBT' => 'Estimated Off-block Time',
	                    'EQPT' => 'Equipment',
	                    'ER' => 'Here',
	                    'ESE' => 'East-south-east',
	                    'EST' => 'Estimate',
	                    'ETA' => 'Estimated Time Of Arrival',
	                    'ETD' => 'Estimated Time Of Departure',
	                    'ETO' => 'Estimated Time Over Significant Point',
	                    'EV' => 'Every',
	                    'EXC' => 'Except',
	                    'EXER' => 'Exercise',
	                    'EXP' => 'Expect',
	                    'EXTD' => 'Extend',
	                    'FAC' => 'Facilities',
	                    'FAF' => 'Final Approach Fix',
	                    'FAL' => 'Facilitation of International Airtransport',
	                    'FAP' => 'Final Approach Point',
	                    'FATO' => 'Final Approach And Take-off Area',
	                    'FAX' => 'Fax',
	                    'FBL' => 'Light',
	                    'FCST' => 'Forecast',
	                    'FCT' => 'Friction Coefficient',
	                    'FDPS' => 'Flight Data Processing System',
	                    'FEB' => 'February',
	                    'FLD' => 'Field',
	                    'FLG' => 'Flashing',
	                    'FLR' => 'Flares',
	                    'FLT' => 'Flight',
	                    'FLTS' => 'Flights',
	                    'FLTCK' => 'Flight Check',
	                    'FLUC' => 'Fluctuating',
	                    'FLW' => 'Follow(s)',
	                    'FLY' => 'Fly',
	                    'FM' => 'From',
	                    'FMS' => 'Flight Management System',
	                    'FMU' => 'Flow Management Unit',
	                    'FNA' => 'Final Approach',
	                    'FPAP' => 'Flight Path Alignment Point',
	                    'FPL' => 'Flight Plan',
	                    'FPLS' => 'Flight Plans',
	                    'FPM' => 'Feet Per Minute',
	                    'FPR' => 'Flight Plan Route',
	                    'FR' => 'Fuel Remaining',
	                    'FREQ' => 'Frequency',
	                    'FRI' => 'Friday',
	                    'FRNG' => 'Firing',
	                    'FRONT' => 'Front',
	                    'FRQ' => 'Frequent',
	                    'FSL' => 'Full Stop Landing',
	                    'FSS' => 'Flight Service Station',
	                    'FST' => 'First',
	                    'FTP' => 'Fictitious Threshold Point',
	                    'G/A' => 'Ground-to-air',
	                    'G/A/G' => 'Ground-to-air and Air-to-ground',
	                    'GARP' => 'GBAS Azimuth Reference Point',
	                    'GBAS' => 'Ground-based Augmentation System',
	                    'GCAJ' => 'Ground Controlled Approach',
	                    'GEN' => 'General',
	                    'GEO' => 'Geographic or True',
	                    'GES' => 'Ground Earth Station',
	                    'GLD' => 'Glider',
	                    'GMC' => 'Ground Movement Chart',
	                    'GND' => 'Ground',
	                    'GNDCK' => 'Ground Check',
	                    'GP' => 'Glide Path',
	                    'GRASS' => 'Grass landing area',
	                    'GRVL' => 'Gravel',
	                    'GUND' => 'Geoid Undulation',
	                    'H24' => '24 Hours',
	                    'HAPI' => 'Helicopter Approach Path Indicator',
	                    'HBN' => 'Hazard Beacon',
	                    'HDG' => 'Heading',
	                    'HEL' => 'Helicopter',
	                    'HGT' => 'Height',
	                    'HJ' => 'Sunrise to Sunset',
	                    'HLDG' => 'Holding',
	                    'HN' => 'Sunset to Sunrise',
	                    'HO' => 'Service Available To Meet Operational Requirements',
	                    'HOL' => 'Holiday',
	                    'HOSP' => 'Hospital Aircraft',
	                    'HOT' => 'Height',
	                    'HPA' => 'Hectopascal',
	                    'HR' => 'Hours',
	                    'HRS' => 'Hours',
	                    'HS' => 'Service Available During Hours Of Scheduled Operations',
	                    'HURCN' => 'Hurricane',
	                    'HVY' => 'Heavy',
	                    'HX' => 'No Specific Working Hours',
	                    'HYR' => 'Higher',
	                    'IAC' => 'Instrument Approach Chart',
	                    'IAF' => 'Initial Approach Fix',
	                    'IAO' => 'In And Out Of Clouds',
	                    'IAP' => 'Instrument Approach Procedure',
	                    'IAR' => 'Intersection Of Air Routes',
	                    'IBN' => 'Identification Beacon',
	                    'ID' => 'Identifier',
	                    'IDENT' => 'Identification',
	                    'IFF' => 'Identification Friend/Foe',
	                    'IGA' => 'International General Aviation',
	                    'IM' => 'Inner Marker',
	                    'IMPR' => 'Improving',
	                    'IMT' => 'Immediately',
	                    'INA' => 'Initial Approach',
	                    'INBD' => 'Inbound',
	                    'INCERFA' => 'Uncertainty Phase',
	                    'INFO' => 'Information',
	                    'INOP' => 'Inoperative',
	                    'INP' => 'If Not Possible',
	                    'INPR' => 'In Progress',
	                    'INSTL' => 'Installation',
	                    'INSTR' => 'Instrument',
	                    'INT' => 'Intersection',
	                    'INTS' => 'Intersections',
	                    'INTL' => 'International',
	                    'INTRG' => 'Interrogator',
	                    'INTRP' => 'Interruption',
	                    'INTSF' => 'Intensifying',
	                    'INTST' => 'Intensity',
	                    'ISA' => 'International Standard Atmosphere',
	                    'JAN' => 'January',
	                    'JTST' => 'Jet stream',
	                    'JUL' => 'July',
	                    'JUN' => 'June',
	                    'KMH' => 'Kilometres Per Hour',
	                    'KPA' => 'Kilopascal',
	                    'KT' => 'Knots',
	                    'KW' => 'Kilowatts',
	                    'LAN' => 'Inland',
	                    'LAT' => 'Latitude',
	                    'LDA' => 'Landing Distance Available',
	                    'LDAH' => 'Landing Distance Available, Helicopter',
	                    'LDG' => 'Landing',
	                    'LDI' => 'Landing Direction Indicator',
	                    'LEN' => 'Length',
	                    'LGT' => 'Lighting',
	                    'LGTD' => 'Lighted',
	                    'LIH' => 'Light Intensity High',
	                    'LIL' => 'Light Intensity Low',
	                    'LIM' => 'Light Intensity Medium',
	                    'LLZ' => 'Localizer',
	                    'LM' => 'Locator, Middle',
	                    'LMT' => 'Local Mean Time',
	                    'LNG' => 'Long',
	                    'LO' => 'Locator, Outer',
	                    'LOG' => 'Located',
	                    'LONG' => 'Longitude',
	                    'LRG' => 'Long Range',
	                    'LTD' => 'Limited',
	                    'LTP' => 'Landing Threshold Point',
	                    'LVE' => 'Leaving',
	                    'LVL' => 'Level',
	                    'LYR' => 'Layer',
	                    'MAA' => 'Maximum Authorized Altitude',
	                    'MAG' => 'Magnetic',
	                    'MAINT' => 'Maintenance',
	                    'MAP' => 'Aeronautical Maps and Charts',
	                    'MAPT' => 'Missed Approach Point',
	                    'MAR' => 'March',
	                    'MAX' => 'Maximum',
	                    'MAY' => 'May',
	                    'MBST' => 'Microburst',
	                    'MCA' => 'Minimum Crossing Altitude',
	                    'MCW' => 'Modulated Continuous Wave',
	                    'MDA' => 'Minimum Descent Altitude',
	                    'MDH' => 'Minimum Descent Height',
	                    'MEA' => 'Minimum En-route Altitude',
	                    'MEHT' => 'Minimum Eye Height Over Threshold',
	                    'MET' => 'Meteorological',
	                    'MID' => 'Mid-point',
	                    'MIL' => 'Military',
	                    'MIN' => 'Minutes',
	                    'MKR' => 'Marker Radio Beacon',
	                    'MLS' => 'Microwave Landing System',
	                    'MM' => 'Middle Marker',
	                    'MNM' => 'Minimum',
	                    'MNPS' => 'Minimum Navigation Performance Specifications',
	                    'MNT' => 'Monitor',
	                    'MNTN' => 'Maintain',
	                    'MOA' => 'Military Operating Area',
	                    'MOC' => 'Minimum Obstacle Clearance',
	                    'MOD' => 'Moderate',
	                    'MON' => 'Monday',
	                    'MOPS' => 'Minimum Operational Performance Standards',
	                    'MOV' => 'Movement',
	                    'MRA' => 'Minimum Reception Altitude',
	                    'MRG' => 'Medium Range',
	                    'MRP' => 'ATS/MET Reporting Point',
	                    'MS' => 'Minus',
	                    'MSA' => 'Minimum Sector Altitude',
	                    'MSAW' => 'Minimum Safe Altitude Warning',
	                    'MSG' => 'Message',
	                    'MSSR' => 'Monopulse Secondary Surveillance Radar',
	                    'MT' => 'Mountain',
	                    'MTU' => 'Metric Units',
	                    'MTW' => 'Mountain Waves',
	                    'NASC' => 'National AIS System Centre',
	                    'NAT' => 'North Atlantic',
	                    'NAV' => 'Navigation',
	                    'NB' => 'Northbound',
	                    'NBFR' => 'Not Before',
	                    'NE' => 'North-east',
	                    'NEB' => 'North-eastbound',
	                    'NEG' => 'Negative',
	                    'NGT' => 'Night',
	                    'NIL' => 'None',
	                    'NML' => 'Normal',
	                    'NNE' => 'North-north-east',
	                    'NNW' => 'North-north-west',
	                    'NOF' => 'International NOTAM Office',
	                    'NOV' => 'November',
	                    'NOZ' => 'Normal Operating Zone',
	                    'NR' => 'Number',
	                    'NRH' => 'No Reply Heard',
	                    'NTL' => 'National',
	                    'NTZ' => 'No Transgression Zone',
	                    'NW' => 'North-west',
	                    'NWB' => 'North-westbound',
	                    'NXT' => 'Next',
	                    'O/R' => 'On Request',
	                    'OAC' => 'Oceanic Area Control Centre',
	                    'OAS' => 'Obstacle Assessment Surface',
	                    'OBS' => 'Observe',
	                    'OBST' => 'Obstacle',
	                    'OBSTS' => 'Obstacles',
	                    'OCA' => 'Oceanic Control Area',
	                    'OCH' => 'Obstacle Clearance Height',
	                    'OCS' => 'Obstacle Clearance Surface',
	                    'OCT' => 'October',
	                    'OFZ' => 'Obstacle Free Zone',
	                    'OGN' => 'Originate',
	                    'OHD' => 'Overhead',
	                    'OM' => 'Outer Marker',
	                    'OPC' => 'Control Indicated Is Operational Control',
	                    'OPMET' => 'Operational Meteorological',
	                    'OPN' => 'Open',
	                    'OPR' => 'Operate',
	                    'OPS' => 'Operations',
	                    'ORD' => 'Order',
	                    'OSV' => 'Ocean Station Vessel',
	                    'OTLK' => 'Outlook',
	                    'OTP' => 'On Top',
	                    'OTS' => 'Organized Track System',
	                    'OUBD' => 'Outbound',
	                    'PA' => 'Precision Approach',
	                    'PALS' => 'Precision Approach Lighting System',
	                    'PANS' => 'Procedures for Air Navigation Services',
	                    'PAR' => 'Precision Approach Radar',
	                    'PARL' => 'Parallel',
	                    'PATC' => 'Precision Approach Terrain Chart',
	                    'PAX' => 'Passenger(s)',
	                    'PCD' => 'Proceed',
	                    'PCL' => 'Pilot-controlled Lighting',
	                    'PCN' => 'Pavement Classification Number',
	                    'PDC' => 'Pre-departure Clearance',
	                    'PDG' => 'Procedure Design Gradient',
	                    'PER' => 'Performance',
	                    'PERM' => 'Permanent',
	                    'PIB' => 'Pre-flight Information Bulletin',
	                    'PJE' => 'Parachute Jumping Exercise',
	                    'PLA' => 'Practice Low Approach',
	                    'PLN' => 'Flight Plan',
	                    'PLVL' => 'Present Level',
	                    'PN' => 'Prior Notice Required',
	                    'PNR' => 'Point Of No Return',
	                    'POB' => 'Persons On Board',
	                    'POSS' => 'Possible',
	                    'PPI' => 'Plan Position Indicator',
	                    'PPR' => 'Prior Permission Required',
	                    'PPSN' => 'Present Position',
	                    'PRI' => 'Primary',
	                    'PRKG' => 'Parking',
	                    'PROB' => 'Probability',
	                    'PROC' => 'Procedure',
	                    'PROV' => 'Provisional',
	                    'PS' => 'Plus',
	                    'PSG' => 'Passing',
	                    'PSN' => 'Position',
	                    'PSNS' => 'Positions',
	                    'PSR' => 'Primary Surveillance Radar',
	                    'PSYS' => 'Pressure System(s)',
	                    'PTN' => 'Procedure Turn',
	                    'PTS' => 'Polar Track Structure',
	                    'PWR' => 'Power',
	                    'QUAD' => 'Quadrant',
	                    'RAC' => 'Rules of The Air and Air Traffic Services',
	                    'RAG' => 'Runway Arresting Gear',
	                    'RAI' => 'Runway Alignment Indicator',
	                    'RASC' => 'Regional AIS System Centre',
	                    'RASS' => 'Remote Altimeter Setting Source',
	                    'RB' => 'Rescue Boat',
	                    'RCA' => 'Reach Cruising Altitude',
	                    'RCC' => 'Rescue Coordination Centre',
	                    'RCF' => 'Radiocommunication Failure',
	                    'RCH' => 'Reaching',
	                    'RCL' => 'Runway Centre Line',
	                    'RCLL' => 'Runway Centre Line Light(s)',
	                    'RCLR' => 'Recleared',
	                    'RDH' => 'Reference Datum Height',
	                    'RDL' => 'Radial',
	                    'RDO' => 'Radio',
	                    'RE' => 'Recent',
	                    'REC' => 'Receiver',
	                    'REDL' => 'Runway Edge Light(s)',
	                    'REF' => 'Refer To',
	                    'REG' => 'Registration',
	                    'RENL' => 'Runway End Light(s)',
	                    'REP' => 'Report',
	                    'REQ' => 'Requested',
	                    'RERTE' => 'Re-route',
	                    'RESA' => 'Runway End Safety Area',
	                    'RG' => 'Range (lights)',
	                    'RHC' => 'Right-hand Circuit',
	                    'RIF' => 'Reclearance In Flight',
	                    'RITE' => 'Right',
	                    'RL' => 'Report Leaving',
	                    'RLA' => 'Relay To',
	                    'RLCE' => 'Request Level Change En Route',
	                    'RLLS' => 'Runway Lead-in Lighting System',
	                    'RLNA' => 'Request Level Not Available',
	                    'RMAC' => 'Radar Minimum Altitude Chart',
	                    'RMK' => 'Remark',
	                    'RNG' => 'Radio Range',
	                    'RNP' => 'Required Navigation Performance',
	                    'ROC' => 'Rate Of Climb',
	                    'ROD' => 'Rate Of Descent',
	                    'ROFOR' => 'Route Forecast',
	                    'RON' => 'Receiving Only',
	                    'RPI' => 'Radar Position Indicator',
	                    'RPL' => 'Repetitive Flight Plan',
	                    'RPLC' => 'Replaced',
	                    'RPS' => 'Radar Position Symbol',
	                    'RQMNTS' => 'Requirements',
	                    'RQP' => 'Request Flight Plan',
	                    'RQS' => 'Request Supplementary Flight Plan',
	                    'RR' => 'Report Reaching',
	                    'RSC' => 'Rescue Sub-centre',
	                    'RSCD' => 'Runway Surface Condition',
	                    'RSP' => 'Responder Beacon',
	                    'RSR' => 'En-route Surveillance Radar',
	                    'RTE' => 'Route',
	                    'RTES' => 'Routes',
	                    'RTF' => 'Radiotelephone',
	                    'RTG' => 'Radiotelegraph',
	                    'RTHL' => 'Runway Threshold Light(s)',
	                    'RTN' => 'Return',
	                    'RTODAH' => 'Rejected Take-off Distance Available, Helicopter',
	                    'RTS' => 'Return To Service',
	                    'RTT' => 'Radioteletypewriter',
	                    'RTZL' => 'Runway Touchdown Zone Light(s)',
	                    'RUT' => 'Standard Regional Route Transmitting Frequencies',
	                    'RV' => 'Rescue Vessel',
	                    'RVSM' => 'Reduced Vertical Separation Minimum',
	                    'RWY' => 'Runway',
	                    'RWYS' => 'Runways',
	                    'SALS' => 'Simple Approach Lighting System',
	                    'SAN' => 'Sanitary',
	                    'SAP' => 'As Soon As Possible',
	                    'SAR' => 'Search and Rescue',
	                    'SARPS' => 'Standards and Recommended Practices',
	                    'SAT' => 'Saturday',
	                    'SATCOM' => 'Satellite Communication',
	                    'SB' => 'Southbound',
	                    'SBAS' => 'Satellite-based Augmentation System',
	                    'SDBY' => 'Stand by',
	                    'SE' => 'South-east',
	                    'SEA' => 'Sea',
	                    'SEB' => 'South-eastbound',
	                    'SEC' => 'Seconds',
	                    'SECN' => 'Section',
	                    'SECT' => 'Sector',
	                    'SEP' => 'September',
	                    'SER' => 'Service',
	                    'SEV' => 'Severe',
	                    'SFC' => 'Surface',
	                    'SGL' => 'Signal',
	                    'SID' => 'Standard Instrument Departure',
	                    'SIF' => 'Selective Identification Feature',
	                    'SIG' => 'Significant',
	                    'SIMUL' => 'Simultaneous',
	                    'SKED' => 'Schedule',
	                    'SLP' => 'Speed Limiting Point',
	                    'SLW' => 'Slow',
	                    'SMC' => 'Surface Movement Control',
	                    'SMR' => 'Surface Movement Radar',
	                    'SPL' => 'Supplementary Flight Plan',
	                    'SPOC' => 'SAR Point Of Contact',
	                    'SPOT' => 'Spot Wind',
	                    'SR' => 'Sunrise',
	                    'SRA' => 'Surveillance Radar Approach',
	                    'SRE' => 'Surveillance Radar Element Of Precision Approach Radar System',
	                    'SRG' => 'Short Range',
	                    'SRR' => 'Search and Rescue Region',
	                    'SRY' => 'Secondary',
	                    'SS' => 'Sunset',
	                    'SSE' => 'South-south-east',
	                    'SSR' => 'Secondary Surveillance Radar',
	                    'SST' => 'Supersonic Transport',
	                    'SSW' => 'South-south-west',
	                    'STA' => 'Straight-in Approach',
	                    'STAR' => 'Standard Instrument Arrival',
	                    'STD' => 'Standard',
	                    'STN' => 'Station',
	                    'STNR' => 'Stationary',
	                    'STOL' => 'Short Take-off and Landing',
	                    'STS' => 'Status',
	                    'STWL' => 'Stopway Light(s)',
	                    'SUBJ' => 'Subject To',
	                    'SUN' => 'Sunday',
	                    'SUP' => 'Supplement',
	                    'SUPPS' => 'Regional Supplementary Procedures Service Message',
	                    'SVCBL' => 'Serviceable',
	                    'SW' => 'South-west',
	                    'SWB' => 'South-westbound',
	                    'SWY' => 'Stopway',
	                    'TA' => 'Transition Altitude',
	                    'TAA' => 'Terminal Arrival Altitude',
	                    'TAF' => 'Aerodrome Forecast',
	                    'TAIL' => 'Tail Wind',
	                    'TAR' => 'Terminal Area Surveillance Radar',
	                    'TAX' => 'Taxi',
	                    'TCAC' => 'Tropical Cyclone Advisory Centre',
	                    'TDO' => 'Tornado',
	                    'TDZ' => 'Touchdown Zone',
	                    'TECR' => 'Technical Reason',
	                    'TEMPO' => 'Temporarily',
	                    'TFC' => 'Traffic',
	                    'TGL' => 'Touch-and-go',
	                    'TGS' => 'Taxiing Guidance System',
	                    'THR' => 'Threshold',
	                    'THRU' => 'Through',
	                    'THU' => 'Thursday',
	                    'TIBA' => 'Traffic Information Broadcast By Aircraft',
	                    'TIL' => 'Until',
	                    'TIP' => 'Until Past',
	                    'TKOF' => 'Take-off',
	                    'TL' => 'Till',
	                    'TLOF' => 'Touchdown And Lift-off Area',
	                    'TMA' => 'Terminal Control Area',
	                    'TNA' => 'Turn Altitude',
	                    'TNH' => 'Turn Height',
	                    'TOC' => 'Top of Climb',
	                    'TODA' => 'Take-off Distance Available',
	                    'TODAH' => 'Take-off Distance Available, Helicopter',
	                    'TORA' => 'Take-off Run Available',
	                    'TP' => 'Turning Point',
	                    'TR' => 'Track',
	                    'TRA' => 'Temporary Reserved Airspace',
	                    'TRANS' => 'Transmitter',
	                    'TRL' => 'Transition Level',
	                    'TUE' => 'Tuesday',
	                    'TURB' => 'Turbulence',
	                    'TVOR' => 'Terminal VOR',
	                    'TWR' => 'Tower',
	                    'TWY' => 'Taxiway',
	                    'TWYL' => 'Taxiway-link',
	                    'TXT' => 'Text',
	                    'TYP' => 'Type of Aircraft',
	                    'U/S' => 'Unserviceable',
	                    'UAB' => 'Until Advised By',
	                    'UAC' => 'Upper Area Control Centre',
	                    'UAR' => 'Upper Air Route',
	                    'UFN' => 'Until Further Notice',
	                    'UHDT' => 'Unable Higher Due Traffic',
	                    'UIC' => 'Upper Information Centre',
	                    'UIR' => 'Upper Flight Information Region',
	                    'ULR' => 'Ultra Long Range',
	                    'UNA' => 'Unable',
	                    'UNAP' => 'Unable To Approve',
	                    'UNL' => 'Unlimited',
	                    'UNREL' => 'Unreliable',
	                    'UTA' => 'Upper Control Area',
	                    'VAAC' => 'Volcanic Ash Advisory Centre',
	                    'VAC' => 'Visual Approach Chart',
	                    'VAL' => 'In Valleys',
	                    'VAN' => 'Runway Control Van',
	                    'VAR' => 'Visual-aural Radio Range',
	                    'VC' => 'Vicinity',
	                    'VCY' => 'Vicinity',
	                    'VER' => 'Vertical',
	                    'VIS' => 'Visibility',
	                    'VLR' => 'Very Long Range',
	                    'VPA' => 'Vertical Path Angle',
	                    'VRB' => 'Variable',
	                    'VSA' => 'By Visual Reference To The Ground',
	                    'VSP' => 'Vertical Speed',
	                    'VTOL' => 'Vertical Take-off And Landing',
	                    'WAC' => 'World Aeronautical Chart',
	                    'WAFC' => 'World Area Forecast Centre',
	                    'WB' => 'Westbound',
	                    'WBAR' => 'Wing Bar Lights',
	                    'WDI' => 'Wind Direction Indicator',
	                    'WDSPR' => 'Widespread',
	                    'WED' => 'Wednesday',
	                    'WEF' => 'Effective From',
	                    'WI' => 'Within',
	                    'WID' => 'Width',
	                    'WIE' => 'Effective Immediately',
	                    'WILCO' => 'Will Comply',
	                    'WIND' => 'Wind',
	                    'WINTEM' => 'Forecast Upper Wind And Temperature For Aviation',
	                    'WIP' => 'Work In Progress',
	                    'WKN' => 'Weaken',
	                    'WNW' => 'West-north-west',
	                    'WO' => 'Without',
	                    'WPT' => 'Way-point',
	                    'WRNG' => 'Warning',
	                    'WSW' => 'West-south-west',
	                    'WT' => 'Weight',
	                    'WWW' => 'Worldwide Web',
	                    'WX' => 'Weather',
	                    'XBAR' => 'Crossbar',
	                    'XNG' => 'Crossing',
	                    'XS' => 'Atmospherics',
	                    'YCZ' => 'Yellow Caution Zone',
	                    'YR' => 'Your');


	public function __construct($dbc = null) {
		$Connection = new Connection($dbc);
		$this->db = $Connection->db;
	}
	public function getAllNOTAM() {
		$query = "SELECT * FROM notam";
		$query_values = array();
		try {
			$sth = $this->db->prepare($query);
			$sth->execute($query_values);
		} catch(PDOException $e) {
			return "error : ".$e->getMessage();
		}
		$all = $sth->fetchAll(PDO::FETCH_ASSOC);
		return $all;
	}

	public function addNOTAM($ref,$title,$type,$fir,$code,$rules,$scope,$lower_limit,$upper_limit,$center_latitude,$center_longitude,$radius,$date_begin,$date_end,$permanent,$text,$full_notam) {
		$query = "INSERT INTO notam (ref,title,notam_type,fir,code,rules,scope,lower_limit,upper_limit,center_latitude,center_longitude,radius,date_begin,date_end,permanent,notam_text,full_notam) VALUES (:ref,:title,:type,:fir,:code,:rules,:scope,:lower_limit,:upper_limit,:center_latitude,:center_longitude,:radius,:date_begin,:date_end,:permanent,:text,:full_notam)";
		$query_values = array(':ref' => $ref,':title' => $title,':type' => $type,':fir' => $fir,':code' => $code,':rules' => $rules,':scope' => $scope,':lower_limit' => $lower_limit,':upper_limit' => $upper_limit,':center_latitude' => $center_latitude,':center_longitude' => $center_longitude,':radius' => $radius,':date_begin' => $date_begin,':date_end' => $date_end,':permanent' => $permanent,':text' => $text,':full_notam' => $full_notam);
		try {
			$sth = $this->db->prepare($query);
			$sth->execute($query_values);
		} catch(PDOException $e) {
			return "error : ".$e->getMessage();
		}
	}

	public function deleteNOTAM($id) {
		$query = "DELETE FROM notam WHERE id = :id";
		$query_values = array(':id' => $id);
		try {
			$sth = $this->db->prepare($query);
			$sth->execute($query_values);
		} catch(PDOException $e) {
			return "error : ".$e->getMessage();
		}
	}
	public function deleteAllNOTAMLocation() {
		$query = "DELETE FROM notam";
		try {
			$sth = $this->db->prepare($query);
			$sth->execute();
		} catch(PDOException $e) {
			return "error : ".$e->getMessage();
		}
	}

	public function updateNotam() {
		global $globalNOTAMAirports;
		if (isset($globalNOTAMAirports) && is_array($globalNOTAMAirports) && count($globalNOTAMAirports) > 0) {
			foreach ($globalNOTAMAirports as $airport) {
				$data = $this->downloadNOTAM($airport);
				if (count($data) > 0) {
					$this->addNOTAM($data['ref'],$data['title'],'',$data['fir'],$data['code'],'',$data['scope'],$data['lower_limit'],$data['upper_limit'],$data['latitude'],$data['longitude'],$data['radius'],$data['date_begin'],$data['date_end'],$data['permanent'],$data['text'],$data['full_notam']);
				}
			}
		}
	}

	public function downloadNOTAM($icao) {
		date_default_timezone_set("UTC");
		$Common = new Common();
		//$url = str_replace('{icao}',$icao,'https://pilotweb.nas.faa.gov/PilotWeb/notamRetrievalByICAOAction.do?method=displayByICAOs&reportType=RAW&formatType=DOMESTIC&retrieveLocId={icao}&actionType=notamRetrievalByICAOs');
		$url = str_replace('{icao}',$icao,'https://pilotweb.nas.faa.gov/PilotWeb/notamRetrievalByICAOAction.do?method=displayByICAOs&reportType=RAW&formatType=ICAO&retrieveLocId={icao}&actionType=notamRetrievalByICAOs');
		$data = $Common->getData($url);
		preg_match_all("/<pre>(.+?)<\/pre>/is", $data, $matches);
		if (isset($matches[1])) return $matches[1];
		else return array();
	}

	public function parse($data) {
		$Common = new Common();
		$result = array();
		$result['full_notam'] = $data;
		$data = str_ireplace(array("\r","\n",'\r','\n'),' ',$data);
		$data = preg_split('#(?=([A-Z]\)\s))#',$data);
		//print_r($data);
		foreach ($data as $line) {
			$line = trim($line);
			if (preg_match('#Q\) (.*)#',$line,$matches)) {
				$line = str_replace(' ','',$line);
				if (preg_match('#Q\)([A-Z]{4})\/([A-Z]{5})\/(IV|I|V)\/([A-Z]{1,3})\/([A-Z]{1,2})\/([0-9]{3})\/([0-9]{3})\/([0-9]{4})(N|S)([0-9]{5})(E|W)([0-9]{3})#',$line,$matches)) {
					//print_r($matches);
					$result['fir'] = $matches[1];
					$result['code'] = $matches[2];
					$rules = str_split($matches[3]);
					foreach ($rules as $rule) {
						if ($rule == 'I') {
							if (isset($result['rules'])) $result['rules'] = $result['rules'].'/IFR';
							else $result['rules'] = 'IFR';
						} elseif ($rule == 'V') {
							if (isset($result['rules'])) $result['rules'] = $result['rules'].'/VFR';
							else $result['rules'] = 'VFR';
						} elseif ($rule == 'K') {
							if (isset($result['rules'])) $result['rules'] = $result['rules'].'/Checklist';
							else $result['rules'] = 'Checklist';
						}
					}
					$attentions = str_split($matches[4]);
					foreach ($attentions as $attention) {
						if ($attention == 'N') {
							if (isset($result['attention'])) $result['attention'] = $result['attention'].' / Immediate attention';
							else $result['rules'] = 'Immediate attention';
						} elseif ($attention == 'B') {
							if (isset($result['attention'])) $result['attention'] = $result['attention'].' / Operational significance';
							else $result['rules'] = 'Operational significance';
						} elseif ($attention == 'O') {
							if (isset($result['attention'])) $result['attention'] = $result['attention'].' / Flight operations';
							else $result['rules'] = 'Flight operations';
						} elseif ($attention == 'M') {
							if (isset($result['attention'])) $result['attention'] = $result['attention'].' / Misc';
							else $result['rules'] = 'Misc';
						} elseif ($attention == 'K') {
							if (isset($result['attention'])) $result['attention'] = $result['attention'].' / Checklist';
							else $result['rules'] = 'Checklist';
						}
					}
					if ($matches[5] == 'A') $result['scope'] = 'Airport warning';
					elseif ($matches[5] == 'E') $result['scope'] = 'Enroute warning';
					elseif ($matches[5] == 'W') $result['scope'] = 'Navigation warning';
					elseif ($matches[5] == 'K') $result['scope'] = 'Checklist';
					elseif ($matches[5] == 'AE') $result['scope'] = 'Airport/Enroute warning';
					elseif ($matches[5] == 'AW') $result['scope'] = 'Airport/Navigation warning';
					$result['lower_limit'] = $matches[6];
					$result['upper_limit'] = $matches[7];
					$latitude = $Common->convertDec($matches[8],'latitude');
					if ($matches[9] == 'S') $latitude = -$latitude;
					$longitude = $Common->convertDec($matches[10],'longitude');
					if ($matches[11] == 'W') $longitude = -$longitude;
					$result['latitude'] = $latitude;
					$result['longitude'] = $longitude;
					$result['radius'] = intval($matches[12]);
				} else echo 'ERROR : '.$line."\n";
			}
			elseif (preg_match('#A\) (.*)#',$line,$matches)) {
				$result['icao'] = $matches[1];
			}
			elseif (preg_match('#B\) ([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})#',$line,$matches)) {
				$result['date_begin'] = $matches[1].'/'.$matches[2].'/'.$matches[3].' '.$matches[4].':'.$matches[5];
			}
			elseif (preg_match('#C\) ([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})$#',$line,$matches)) {
				$result['date_finish'] = $matches[1].'/'.$matches[2].'/'.$matches[3].' '.$matches[4].':'.$matches[5];
			}
			elseif (preg_match('#C\) ([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2})([0-9]{2}) (EST|PERM)$#',$line,$matches)) {
				$result['date_finish'] = $matches[1].'/'.$matches[2].'/'.$matches[3].' '.$matches[4].':'.$matches[5];
				if ($matches[6] == 'EST') $result['estimated'] = true;
				else $result['estimated'] = false;
				if ($matches[6] == 'PERM') $result['permanent'] = true;
				else $result['permanent'] = false;
			}
			elseif (preg_match('#E\) (.*)#',$line,$matches)) {
				$rtext = array();
				$text = explode(' ',$matches[1]);
				foreach ($text as $word) {
					if (isset($this->abbr[$word])) $rtext[] = strtoupper($this->abbr[$word]);
					elseif (ctype_digit(strval(substr($word,3))) && isset($this->abbr[substr($word,0,3)])) $rtext[] = strtoupper($this->abbr[substr($word,0,3)]).' '.substr($word,3);
					else $rtext[] = $word;
				}
				$result['text'] = implode(' ',$rtext);
			//} elseif (preg_match('#F\) (.*)#',$line,$matches)) {
			//} elseif (preg_match('#G\) (.*)#',$line,$matches)) {
			} elseif (preg_match('#(NOTAMN|NOTAMR|NOTAMC)$#',$line,$matches)) {
				if ($matches[1] == 'NOTAMN') $result['type'] = 'new';
				if ($matches[1] == 'NOTAMC') $result['type'] = 'cancel';
				if ($matches[1] == 'NOTAMC') $result['type'] = 'replace';
			}
		}
		return $result;
	}
}
/*
$NOTAM = new NOTAM();
//print_r($NOTAM->downloadNOTAM('lfll'));
print_r($NOTAM->parse(''));
*/
?>