<?php
// stars.php
// 讀取參數：支援 GET / POST
$start  = isset($_REQUEST['start'])  ? intval($_REQUEST['start'])  : 0;
$target = isset($_REQUEST['target']) ? intval($_REQUEST['target']) : 0;
// 防呆與上限（可按需要調整）
$MAX_STARS = 500;
$start  = max(0, min($start,  $MAX_STARS));
$target = max(0, min($target, $start)); // 亮的星不會多於總星數
// 圖片路徑（如在其他資料夾，改相對路徑即可）
$img_off = 'star.png';
$img_on  = 'starshine.png';
// 用作 ARIA/alt 文案
$total_label  = "合共 {$start} 粒星星，已點亮 {$target} 粒。";
?>
<!DOCTYPE html>
<html lang="zh-HK">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>星星牆</title>
<style>
   :root { --cell: 64px; }
   html, body { margin:0; padding:0; }
   body {
     font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Noto Sans TC", "PingFang HK", "PingFang TC", "Microsoft JhengHei", Arial, sans-serif;
     background: #fff;
     color: #222;
   }
   .wall {
     display: grid;
     grid-template-columns: repeat(10, minmax(0, 1fr)); /* 每行 10 粒 */
     gap: 10px;
     padding: 16px;
     max-width: calc(10 * var(--cell) + 9 * 10px + 32px);
     margin: 0 auto;
   }
   .star {
     width: var(--cell);
     height: var(--cell);
     display: flex; align-items: center; justify-content: center;
   }
   .star img {
     width: 100%;
     height: 100%;
     object-fit: contain;
     display: block;
     image-rendering: auto;
   }
   .legend {
     text-align: center;
     margin: 8px 0 0;
     font-size: 14px;
     opacity: .75;
   }
   /* 手機細啲就縮格仔 */
   @media (max-width: 480px) {
     :root { --cell: 44px; }
     .wall { gap: 8px; padding: 12px; }
   }
</style>
</head>
<body>
<main aria-label="<?php echo htmlspecialchars($total_label, ENT_QUOTES, 'UTF-8'); ?>">
<section class="wall" role="list" aria-describedby="legend">
<?php for ($i = 1; $i <= $start; $i++):
       $on = ($i <= $target);
       $src = $on ? $img_on : $img_off;
       $alt = $on ? "已點亮的星星（第 {$i} 粒）" : "未點亮的星星（第 {$i} 粒）";
     ?>
<div class="star" role="listitem">
<img src="<?php echo htmlspecialchars($src, ENT_QUOTES, 'UTF-8'); ?>"
              alt="<?php echo htmlspecialchars($alt, ENT_QUOTES, 'UTF-8'); ?>">
</div>
<?php endfor; ?>
<?php if ($start === 0): ?>
<div class="legend" style="grid-column: 1 / -1;">暫時未有星星可顯示。</div>
<?php endif; ?>
</section>
<p id="legend" class="legend">合共 <?php echo $start; ?> 粒；已點亮 <?php echo $target; ?> 粒。</p>
</main>
</body>
</html>
