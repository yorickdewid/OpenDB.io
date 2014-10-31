<?php

switch (getRoute()) {
	case "docs/quick":
		View(LAYOUT, "Header3", "Features");
		break;

	default:
		View(LAYOUT, "Header", "Features");
		break;
}
?>