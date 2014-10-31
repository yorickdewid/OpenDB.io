<?php

switch (getRoute()) {
	case "docs/quick":
		View(LAYOUT, "Header3", "Quick");
		break;

	default:
		View(LAYOUT, "Header", "Features");
		break;
}
?>