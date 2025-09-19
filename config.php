<?php
// config.php — tweak as needed
date_default_timezone_set('Europe/London'); // adjust if needed

// Where CSV & uploads live (absolute paths)
define('STORAGE_DIR', __DIR__ . '/data');
define('UPLOAD_DIR_DEFECTS', __DIR__ . '/uploads/defects');
define('UPLOAD_DIR_RECEIPTS', __DIR__ . '/uploads/receipts');

// For building file links in the viewer; set to your deployed base URL (no trailing slash)
define('BASE_URL', ''); // e.g., 'https://example.com/vehicle-check'

// CSV file path
define('CSV_PATH', STORAGE_DIR . '/vehicle_checks.csv');

// Column headings (MUST stay in sync with write order)
$COLUMNS = [
  'Timestamp',
  'Fuel/Oil Leek',
  'Battery Safety',
  'Tyres/Wheels',
  'Seatbelt',
  'Steering',
  'Seat Condition',
  'Lights',
  'Reflectors',
  'Indicators',
  'Wipers',
  'Washers',
  'Horn',
  'Fire Exit',
  'Interior condition',
  'Exit signs',
  'Body damage',
  'Breaks',
  'Body/Wings',
  'Door signs',
  'First-aid box',
  'Notes of any defects',
  'Actions Taken to Resolve if any Defect',
  'Pic of defect',
  'Pic of receipt of any defect fix'
];

// Ensures directories exist
foreach ([STORAGE_DIR, UPLOAD_DIR_DEFECTS, UPLOAD_DIR_RECEIPTS] as $dir) {
  if (!is_dir($dir)) { @mkdir($dir, 0775, true); }
}
