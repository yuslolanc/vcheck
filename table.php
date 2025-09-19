<?php
require_once __DIR__ . '/config.php';

function build_file_url($type, $filename) {
  if (!$filename) return '';
  $base = rtrim(BASE_URL, '/');
  $rel = $type === 'defect' ? 'uploads/defects/' : 'uploads/receipts/';
  if ($base) return $base . '/' . $rel . $filename;
  // Fallback to relative path
  return $rel . $filename;
}

$rows = [];
if (file_exists(CSV_PATH)) {
  if (($handle = fopen(CSV_PATH, 'r')) !== false) {
    while (($data = fgetcsv($handle)) !== false) { $rows[] = $data; }
    fclose($handle);
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Vehicle Checks — Log</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .sticky { position: sticky; left: 0; background:#fff; }
  </style>
</head>
<body>
<div class="container">
  <h1>Vehicle Checks — Log</h1>
  <p class="help">✅ = OK, ❌ = DEFECT. Click file names to open images/receipts.</p>
  <?php if (isset($_GET['ok'])): ?>
    <p class="help" style="color:green">Submission saved.</p>
  <?php endif; ?>

  <div class="card" style="overflow:auto; max-width:100%;">
    <table class="table">
      <thead>
        <tr>
          <?php
          if ($rows) {
            foreach ($rows[0] as $head) {
              echo '<th>' . htmlspecialchars($head) . '</th>';
            }
          }
          ?>
        </tr>
      </thead>
      <tbody>
        <?php
        for ($i = 1; $i < count($rows); $i++) {
          echo '<tr>';
          $cols = $rows[$i];
          for ($c = 0; $c < count($cols); $c++) {
            $val = $cols[$c];
            // Columns 1..20 are check items (index 1..20)
            if ($c >= 1 && $c <= 20) {
              $icon = ($val === 'OK') ? '✅' : '❌';
              echo '<td class="'.($val==='OK'?'ok':'no').'">'.$icon.'</td>';
            } elseif ($c == 23 || $c == 24) {
              // File columns: 23 defect, 24 receipt
              if ($val) {
                $type = ($c == 23) ? 'defect' : 'receipt';
                $url = build_file_url($type, $val);
                echo '<td><a href="'.htmlspecialchars($url).'" target="_blank">'.htmlspecialchars($val).'</a></td>';
              } else {
                echo '<td></td>';
              }
            } else {
              echo '<td class="'.($c>=21?'note':'').'">'.htmlspecialchars($val).'</td>';
            }
          }
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>

  <p class="help"><a href="index.php">Submit another</a></p>
</div>
</body>
</html>
