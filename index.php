<?php
require_once __DIR__ . '/config.php';
$today = date('d/m/Y');
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Daily Vehicle Check</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container">
  <h1>Daily Vehicle Check</h1>
  <p class="help">Default mode is <strong>All OK for today (<?=htmlspecialchars($today)?>)</strong>. If you found any issue, switch to <em>Report Defects</em>.</p>

  <div class="switcher">
    <button id="modeOk" class="btn">All OK</button>
    <button id="modeDefect" class="btn">Report Defects</button>
    <span id="modeBadge" class="badge">Mode: All OK</span>
  </div>

  <form class="card" id="checkForm" action="submit.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="mode" id="modeInput" value="ok">

    <div id="okBlock">
      <p>No inputs needed — press the button below to mark <strong>ALL checks OK</strong> for <strong><?=htmlspecialchars($today)?></strong>.</p>
      <div class="actions">
        <button type="submit" class="primary">✅ Submit All OK</button>
      </div>
    </div>

    <div id="defectBlock" style="display:none">
      <div class="row">
        <?php
        // Items (must match order in config minus meta columns)
        $items = [
          'Fuel/Oil Leek','Battery Safety','Tyres/Wheels','Seatbelt','Steering','Seat Condition','Lights','Reflectors',
          'Indicators','Wipers','Washers','Horn','Fire Exit','Interior condition','Exit signs','Body damage','Breaks',
          'Body/Wings','Door signs','First-aid box'
        ];
        foreach ($items as $key) {
          $name = 'item_' . md5($key);
          echo '<div class="card"><label>' . htmlspecialchars($key) . '</label>';
          echo '<label><input type="checkbox" name="' . htmlspecialchars($name) . '" value="DEFECT"> Mark as DEFECT</label>';
          echo '<p class="help">Unchecked means OK.</p></div>';
        }
        ?>
      </div>

      <div class="card">
        <label>Notes of any defects</label>
        <textarea name="defect_notes" rows="3" style="width:100%" placeholder="Describe what you found..."></textarea>
      </div>

      <div class="card">
        <label>Actions Taken to Resolve if any Defect</label>
        <textarea name="actions_taken" rows="3" style="width:100%" placeholder="What did you do or plan to do?"></textarea>
      </div>

      <div class="row">
        <div class="card">
          <label>📷 Pic of defect</label>
          <input type="file" name="defect_pic" accept="image/*">
          <p class="help">Optional but recommended when reporting a defect.</p>
        </div>
        <div class="card">
          <label>🧾 Pic of receipt of any defect fix</label>
          <input type="file" name="receipt_pic" accept="image/*,application/pdf">
          <p class="help">Optional — upload a receipt or proof (image/PDF).</p>
        </div>
      </div>

      <div class="actions">
        <button type="submit" class="primary">📮 Submit Defect Report</button>
      </div>
    </div>
  </form>

  <p class="help">View log: <a href="table.php">Spreadsheet view</a> · Data file: <code>data/vehicle_checks.csv</code></p>
  <p><small class="mono">Timestamp will be saved in UK format DD/MM/YYYY HH:MM</small></p>
</div>

<script>
const modeInput = document.getElementById('modeInput');
const okBlock = document.getElementById('okBlock');
const defectBlock = document.getElementById('defectBlock');
const badge = document.getElementById('modeBadge');

document.getElementById('modeOk').addEventListener('click', (e)=>{
  e.preventDefault();
  modeInput.value = 'ok';
  okBlock.style.display = '';
  defectBlock.style.display = 'none';
  badge.textContent = 'Mode: All OK';
});

document.getElementById('modeDefect').addEventListener('click', (e)=>{
  e.preventDefault();
  modeInput.value = 'defect';
  okBlock.style.display = 'none';
  defectBlock.style.display = '';
  badge.textContent = 'Mode: Report Defects';
});
</script>
</body>
</html>
