<?php

// Kiểm tra chuỗi có phải là số (số nguyên hoặc số thực), cho phép dấu '-' ở đầu và một dấu '.'
function laSo($s) {
    $s = trim((string)$s);
    if ($s === "") return false;
    $dot = 0;
    for ($i = 0; $i < strlen($s); $i++) {
        $ch = $s[$i];
        if ($i == 0 && $ch == '-') continue;
        if ($ch == '.') {
            $dot++;
            if ($dot > 1) return false;
            continue;
        }
        if ($ch < '0' || $ch > '9') return false;
    }
    // trường hợp chỉ dấu '-' hoặc '.' hoặc '-.' không phải số
    if ($s == '-' || $s == '.' || $s == '-.') return false;
    return true;
}

// Kiểm tra chuỗi có phải là số nguyên (không có dấu chấm)
function laSoNguyen($s) {
    $s = trim((string)$s);
    if ($s === "") return false;
    for ($i = 0; $i < strlen($s); $i++) {
        $ch = $s[$i];
        if ($i == 0 && $ch == '-') continue;
        if ($ch < '0' || $ch > '9') return false;
    }
    if ($s == '-') return false;
    return true;
}

// Kiểm tra số chẵn (nhận tham số dạng chuỗi hoặc số) - dùng laSoNguyen
function kiemTraSoChan($n) {
    if (!laSoNguyen($n)) return null; // null nghĩa không phải số nguyên
    $v = intval($n);
    return $v % 2 == 0;
}

// Kiểm tra số nguyên tố (chỉ cho số nguyên >=2)
function kiemTraSoNguyenTo($n) {
    if (!laSoNguyen($n)) return false;
    $v = intval($n);
    if ($v < 2) return false;
    if ($v == 2) return true;
    if ($v % 2 == 0) return false;
    $r = floor(sqrt($v));
    for ($i = 3; $i <= $r; $i += 2) {
        if ($v % $i == 0) return false;
    }
    return true;
}

// Bubble sort tăng dần (không dùng sort())
function sapXepTangDan($arr) {
    // đảm bảo mảng là các số (dạng chuỗi -> chuyển float)
    $n = count($arr);
    for ($i = 0; $i < $n; $i++) {
        for ($j = 0; $j < $n - $i - 1; $j++) {
            if ($arr[$j] > $arr[$j+1]) {
                $tmp = $arr[$j];
                $arr[$j] = $arr[$j+1];
                $arr[$j+1] = $tmp;
            }
        }
    }
    return $arr;
}

// Tìm các số nguyên tố trong mảng
function timSoNguyenTo($arr) {
    $res = [];
    foreach ($arr as $x) {
        // chỉ xét số nguyên
        if (laSoNguyen($x) && kiemTraSoNguyenTo($x)) $res[] = intval($x);
    }
    return $res;
}


// Đảo ngược chuỗi (tự viết)
function daoNguocChuoi($s) {
    $kq = "";
    for ($i = strlen($s) - 1; $i >= 0; $i--) {
        $kq .= $s[$i];
    }
    return $kq;
}

function demTu($s) {
    $s = trim($s);
    if ($s == "") return 0;

    $arr = explode(" ", $s);
    $dem = 0;
    foreach ($arr as $t) {
        if ($t != "") $dem++;
    }
    return $dem;
}

function kiemTraPalindrome($s) {
    $s = strtolower($s);
    $clean = "";

    // loại khoảng trắng
    for ($i = 0; $i < strlen($s); $i++) {
        if ($s[$i] != " ") {
            $clean .= $s[$i];
        }
    }

    // đảo chuỗi
    $dao = "";
    for ($i = strlen($clean) - 1; $i >= 0; $i--) {
        $dao .= $clean[$i];
    }

    return $clean === $dao;
}

// Tổng các chữ số của một số nguyên (lấy phần nguyên)
function tongChuSo($n) {
    if (!laSo($n)) return null;
    // dùng phần nguyên tuyệt đối
    $v = abs(intval(floatval($n)));
    $sum = 0;
    if ($v == 0) return 0;
    while ($v > 0) {
        $sum += $v % 10;
        $v = intval($v / 10);
    }
    return $sum;
}

// Các hàm Bài 1

function tong2($a, $b) { return $a + $b; }
function hieu2($a, $b) { return $a - $b; }
function tich2($a, $b) { return $a * $b; }


// XỬ LÝ FORM (một file nhiều form)
$errors = [];
$results = [];

// Bài 1: phép toán 2 số (kiểm tra nhập số)
if (isset($_POST['b1_submit'])) {
    $a = isset($_POST['b1_a']) ? $_POST['b1_a'] : '';
    $b = isset($_POST['b1_b']) ? $_POST['b1_b'] : '';
    if (!laSo($a)) $errors['b1'] = "Bài 1: Giá trị a không phải số hợp lệ.";
    if (!laSo($b)) $errors['b1'] = (isset($errors['b1']) ? $errors['b1'] . ' ' : '') . "Giá trị b không phải số hợp lệ.";
    if (!isset($errors['b1'])) {
        $fa = floatval($a);
        $fb = floatval($b);
        $results['b1'] = [
            'tong' => tong2($fa, $fb),
            'hieu' => hieu2($fa, $fb),
            'tich' => tich2($fa, $fb)
        ];
    }
}

// Bài 2: kiểm tra chẵn & nguyên tố (nhập 1 số nguyên)
if (isset($_POST['b2_submit'])) {
    $n = isset($_POST['b2_n']) ? $_POST['b2_n'] : '';
    if (!laSoNguyen($n)) {
        $errors['b2'] = "Bài 2: Vui lòng nhập số nguyên hợp lệ.";
    } else {
        $results['b2'] = [
            'chan' => kiemTraSoChan($n) ? 'Là số chẵn' : 'Là số lẻ',
            'nguyento' => kiemTraSoNguyenTo($n) ? 'Là số nguyên tố' : 'Không phải số nguyên tố'
        ];
    }
}

// Bài 3: sắp xếp mảng tăng dần (nhập dãy số cách nhau bởi dấu phẩy)
if (isset($_POST['b3_submit'])) {
    $raw = isset($_POST['b3_arr']) ? $_POST['b3_arr'] : '';
    $parts = array_map('trim', explode(',', $raw));
    $vals = [];
    $bad = false;
    foreach ($parts as $p) {
        if ($p === '') continue;
        if (!laSo($p)) { $bad = true; break; }
        $vals[] = floatval($p);
    }
    if ($bad || count($vals) == 0) $errors['b3'] = "Bài 3: Vui lòng nhập dãy số hợp lệ, cách nhau dấu phẩy.";
    else $results['b3'] = sapXepTangDan($vals);
}

// Bài 4: tìm số nguyên tố trong mảng (nhập dãy số cách nhau bởi dấu phẩy)
if (isset($_POST['b4_submit'])) {
    $raw = isset($_POST['b4_arr']) ? $_POST['b4_arr'] : '';
    $parts = array_map('trim', explode(',', $raw));
    $vals = [];
    foreach ($parts as $p) {
        if ($p === '') continue;
        $vals[] = $p;
    }
    if (count($vals) == 0) $errors['b4'] = "Bài 4: Vui lòng nhập dãy số.";
    else $results['b4'] = timSoNguyenTo($vals);
}

// Bài 5: xử lý chuỗi: đảo chuỗi, đếm từ, kiểm tra palindrome
if (isset($_POST['b5_submit'])) {
    $s = isset($_POST['b5_str']) ? $_POST['b5_str'] : '';
    if (trim($s) === '') $errors['b5'] = "Bài 5: Vui lòng nhập chuỗi.";
    else {
        $results['b5'] = [
            'daonguoc' => daoNguocChuoi($s),
            'demtu' => demTu($s),
            'palindrome' => kiemTraPalindrome($s) ? 'Là palindrome' : 'Không phải palindrome'
        ];
    }
}

// Bài 6: tổng các chữ số của số nguyên
if (isset($_POST['b6_submit'])) {
    $n = isset($_POST['b6_n']) ? $_POST['b6_n'] : '';
    if (!laSo($n)) $errors['b6'] = "Bài 6: Vui lòng nhập 1 số hợp lệ.";
    else {
        $t = tongChuSo($n);
        if ($t === null) $errors['b6'] = "Bài 6: Không thể tính tổng chữ số.";
        else $results['b6'] = $t;
    }
}

?>
<!doctype html>
<html lang="vi">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Bài tập PHP (Bài 1 - 6) - Gộp 1 file</title>
<style>
  :root{--bg:#f6f9fc;--card:#ffffff;--accent:#0ea5e9;--err:#ef4444;--ok:#10b981;--muted:#64748b}
  *{box-sizing:border-box;font-family:Inter, Roboto, "Segoe UI", system-ui, Arial}
  body{margin:0;background:linear-gradient(180deg,#e6f2fb,#f8fafc);color:#04314a;padding:24px}
  .wrap{max-width:980px;margin:0 auto}
  header{display:flex;align-items:center;gap:12px;margin-bottom:18px}
  h1{margin:0;font-size:20px}
  .grid{display:grid;grid-template-columns:1fr;gap:14px}
  .card{background:var(--card);border-radius:10px;padding:14px;border:1px solid rgba(3,7,18,0.06);box-shadow:0 6px 18px rgba(2,6,23,0.06)}
  label{display:block;margin-bottom:6px;font-weight:600}
  input[type="text"], textarea {width:100%;padding:8px;border-radius:8px;border:1px solid #d1e8f7;background:#fbfeff}
  textarea{min-height:80px;resize:vertical}
  .btn{background:var(--accent);color:white;padding:8px 12px;border-radius:8px;border:none;cursor:pointer;font-weight:700}
  .row{display:flex;gap:8px;flex-wrap:wrap}
  .note{color:var(--muted);font-size:13px}
  .err{color:var(--err);font-weight:700}
  .ok{color:var(--ok);font-weight:700}
  pre.out{background:#0b1220;color:#cfe8ff;padding:12px;border-radius:8px;overflow:auto}
  .small{font-size:13px;color:var(--muted)}
  .two{display:grid;grid-template-columns:1fr 1fr;gap:8px}
  @media (max-width:700px){ .two{grid-template-columns:1fr} }
</style>
</head>
<body>
<div class="wrap">

  <div class="grid">

    <!-- BÀI 1 -->
    <div class="card" id="b1">
      <h2>Bài 1 — Hàm tính toán cơ bản (tổng, hiệu, tích)</h2>
      <p class="small">Nhập a, b (chấp nhận số nguyên hoặc thực). Nếu nhập chữ sẽ báo lỗi.</p>
      <?php if(isset($errors['b1'])): ?><div class="err"><?=htmlspecialchars($errors['b1'])?></div><?php endif; ?>
      <?php if(isset($results['b1'])): ?>
        <div class="ok">Kết quả:</div>
        <pre class="out"><?= "Tổng: ".$results['b1']['tong']."\nHiệu: ".$results['b1']['hieu']."\nTích: ".$results['b1']['tich']?></pre>
      <?php endif; ?>
      <form method="post" class="two">
        <div>
          <label>Nhập a</label>
          <input type="text" name="b1_a" placeholder="Ví dụ: 12 hoặc -3.5" required>
        </div>
        <div>
          <label>Nhập b</label>
          <input type="text" name="b1_b" placeholder="Ví dụ: 4 hoặc 2.25" required>
        </div>
        <div style="grid-column:1/-1;margin-top:8px">
          <button class="btn" name="b1_submit" type="submit">Tính toán</button>
        </div>
      </form>
    </div>

    <!-- BÀI 2 -->
    <div class="card" id="b2">
      <h2>Bài 2 — Kiểm tra số</h2>
      <p class="small">Nhập 1 <strong>số nguyên</strong> để kiểm tra chẵn/lẻ và nguyên tố.</p>
      <?php if(isset($errors['b2'])): ?><div class="err"><?=htmlspecialchars($errors['b2'])?></div><?php endif; ?>
      <?php if(isset($results['b2'])): ?>
        <pre class="out"><?= "Kết luận: ".$results['b2']['chan']."\n". $results['b2']['nguyento'] ?></pre>
      <?php endif; ?>
      <form method="post">
        <label>Nhập số nguyên n</label>
        <input type="text" name="b2_n" placeholder="Ví dụ: 7" required>
        <div style="margin-top:8px">
          <button class="btn" name="b2_submit" type="submit">Kiểm tra</button>
        </div>
      </form>
    </div>

    <!-- BÀI 3 -->
    <div class="card" id="b3">
      <h2>Bài 3 — Sắp xếp mảng tăng dần (không dùng sort())</h2>
      <p class="small">Nhập dãy số cách nhau bằng dấu phẩy (ví dụ: 3, 1.2, -5, 7)</p>
      <?php if(isset($errors['b3'])): ?><div class="err"><?=htmlspecialchars($errors['b3'])?></div><?php endif; ?>
      <?php if(isset($results['b3'])): ?>
        <div class="ok">Mảng sau khi sắp xếp:</div>
        <pre class="out"><?= implode(', ', $results['b3']) ?></pre>
      <?php endif; ?>
      <form method="post">
        <label>Nhập dãy số</label>
        <input type="text" name="b3_arr" placeholder="3,1,4,2">
        <div style="margin-top:8px">
          <button class="btn" name="b3_submit" type="submit">Sắp xếp</button>
        </div>
      </form>
    </div>

    <!-- BÀI 4 -->
    <div class="card" id="b4">
      <h2>Bài 4 — Tìm các số nguyên tố trong mảng</h2>
      <p class="small">Nhập dãy (ví dụ: 3,4,5,6,7) → trả về [3,5,7]</p>
      <?php if(isset($errors['b4'])): ?><div class="err"><?=htmlspecialchars($errors['b4'])?></div><?php endif; ?>
      <?php if(isset($results['b4'])): ?>
        <div class="ok">Số nguyên tố tìm được:</div>
        <pre class="out"><?= count($results['b4']) ? implode(', ', $results['b4']) : 'Không có số nguyên tố' ?></pre>
      <?php endif; ?>
      <form method="post">
        <label>Nhập dãy số</label>
        <input type="text" name="b4_arr" placeholder="3,4,5,6,7">
        <div style="margin-top:8px">
          <button class="btn" name="b4_submit" type="submit">Tìm nguyên tố</button>
        </div>
      </form>
    </div>

    <!-- BÀI 5 -->
    <div class="card" id="b5">
      <h2>Bài 5 — Xử lý chuỗi</h2>
      <p class="small">Đảo chuỗi, đếm số từ, kiểm tra palindrome (bỏ dấu và khoảng trắng, không phân biệt hoa thường)</p>
      <?php if(isset($errors['b5'])): ?><div class="err"><?=htmlspecialchars($errors['b5'])?></div><?php endif; ?>
      <?php if(isset($results['b5'])): ?>
        <pre class="out"><?= "Đảo chuỗi: ".$results['b5']['daonguoc']."\nSố từ: ".$results['b5']['demtu']."\nPalindrome: ".$results['b5']['palindrome'] ?></pre>
      <?php endif; ?>
      <form method="post">
        <label>Nhập chuỗi</label>
        <textarea name="b5_str" placeholder="Nhập văn bản..."></textarea>
        <div style="margin-top:8px">
          <button class="btn" name="b5_submit" type="submit">Xử lý</button>
        </div>
      </form>
    </div>

    <!-- BÀI 6 -->
    <div class="card" id="b6">
      <h2>Bài 6 — Tổng các chữ số</h2>
      <p class="small">Nhập 1 số (số thực hoặc nguyên) → lấy phần nguyên rồi cộng các chữ số.</p>
      <?php if(isset($errors['b6'])): ?><div class="err"><?=htmlspecialchars($errors['b6'])?></div><?php endif; ?>
      <?php if(isset($results['b6'])): ?>
        <div class="ok">Tổng chữ số: <?=htmlspecialchars($results['b6'])?></div>
      <?php endif; ?>
      <form method="post">
        <label>Nhập số</label>
        <input type="text" name="b6_n" placeholder="Ví dụ: 1234 hoặc -56.78">
        <div style="margin-top:8px">
          <button class="btn" name="b6_submit" type="submit">Tính tổng chữ số</button>
        </div>
      </form>
    </div>

  </div>

</div>
</body>
</html>
