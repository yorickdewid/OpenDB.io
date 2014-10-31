<?php

switch (getRoute()) {
	case "blog":
		View(LAYOUT, "Header.blog", "Blog");
		break;

	case "docs/quick":
		View(LAYOUT, "Header.docs", "Quick");
		break;

	default:
		View(LAYOUT, "Header", "Features");
		break;
}
?>