# Vehicle Daily Check (PHP + CSV)

A super-simple daily vehicle check form that **auto-fills today** and lets you submit with **one "All OK" button**.  
If there’s any defect, switch to **Report Defects**, add notes, and upload **a photo of the defect** and an **optional receipt**.

Data is saved to `data/vehicle_checks.csv` and the images go under `uploads/`.

### Files
- `index.php` — the form (All OK or Report Defects).
- `submit.php` — handles submissions, saves CSV and files.
- `table.php` — spreadsheet-like view with ✅ for OK and ❌ for defects.
- `config.php` — adjust `BASE_URL` (for linking images) and storage paths if needed.
- `style.css` — minimal styling.

### Deploy
1. Upload the folder to your PHP host (e.g., `/vehicle-check/`).
2. Ensure the web server can write to `data/` and `uploads/` (permissions 755/775 or 777 if needed).
3. Visit `index.php` to submit, `table.php` to view the log.

### Google Sheets
Open `data/vehicle_checks.csv` directly in Google Sheets or set up a periodic import.

### Security notes
- This is intentionally simple and unauthenticated. If used publicly, add HTTP Auth or IP allow‑lists.
- Max upload size is limited by your PHP config (`upload_max_filesize`, `post_max_size`).

### License
MIT — do what you like.
