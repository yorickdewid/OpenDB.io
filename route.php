<?php

switch (getRoute()) {
	case "test":
		Controller("Test");
		break;

	case "support":
		View(LAYOUT, "Header.support", "Support");
		break;

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