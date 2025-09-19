<?php
require_once __DIR__ . '/config.php';

// Helper to save upload and return relative path
function save_upload($field, $dest_dir) {
  if (!isset($_FILES[$field]) || !is_uploaded_file($_FILES[$field]['tmp_name'])) return '';
  $ext = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
  $ext = $ext ? ('.' . strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $ext))) : '';
  $basename = date('Ymd_His') . '_' . bin2hex(random_bytes(4)) . $ext;
  $target = rtrim($dest_dir, '/') . '/' . $basename;
  if (@move_uploaded_file($_FILES[$field]['tmp_name'], $target)) {
    return $basename; // return filename; we’ll join with BASE_URL in viewer
  }
  return '';
}

$mode = $_POST['mode'] ?? 'ok';
$timestamp = date('d/m/Y H:i');

$items = [
  'Fuel/Oil Leek','Battery Safety','Tyres/Wheels','Seatbelt','Steering','Seat Condition','Lights','Reflectors',
  'Indicators','Wipers','Washers','Horn','Fire Exit','Interior condition','Exit signs','Body damage','Breaks',
  'Body/Wings','Door signs','First-aid box'
];

$row = [];
$row[] = $timestamp;

if ($mode === 'ok') {
  foreach ($items as $label) { $row[] = 'OK'; }
  $notes = ''; $actions = ''; $defect_file = ''; $receipt_file = '';
} else {
  // Default OK, override to DEFECT if box ticked
  foreach ($items as $label) {
    $name = 'item_' . md5($label);
    $row[] = isset($_POST[$name]) && $_POST[$name] === 'DEFECT' ? 'DEFECT' : 'OK';
  }
  $notes = trim($_POST['defect_notes'] ?? '');
  $actions = trim($_POST['actions_taken'] ?? '');
  $defect_file = save_upload('defect_pic', UPLOAD_DIR_DEFECTS);
  $receipt_file = save_upload('receipt_pic', UPLOAD_DIR_RECEIPTS);
}

$row[] = $notes;
$row[] = $actions;
$row[] = $defect_file;
$row[] = $receipt_file;

// Write CSV (create header if missing)
$need_header = !file_exists(CSV_PATH);
$fp = fopen(CSV_PATH, 'a');
if (!$fp) { http_response_code(500); echo "Cannot write to CSV."; exit; }
if ($need_header) {
  global $COLUMNS;
  fputcsv($fp, $COLUMNS);
}
fputcsv($fp, $row);
fclose($fp);

// Redirect to viewer
header('Location: table.php?ok=1');
exit;
