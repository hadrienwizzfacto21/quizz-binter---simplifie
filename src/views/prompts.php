<script>
    let redirect_Page = () => {
        let tID = setTimeout(function() {
            window.location.href = "./";
            window.clearTimeout(tID);
        }, 10000);
    }
</script>

<?php

$currentPage = "prompts";
$levelName = "prompts";

echo "<div class='--full-grid-medium'>";
include "./src/components/prompts/prompts.php";
echo "</div>";

$logs->add($currentPage, "NAV");

if (($_GET["opt"] !== "startOPPage") && ($_GET["opt"] !== "endOPPage")) echo "<script>redirect_Page()</script>";
