<nav class="desktop-menu">
  <ul class="sf-menu">
    <li <? echo(getRoute()==""?"class=\"current-menu-item\"":""); ?>><a href="/">HOME</a></li>
    <li <? echo(getRoute()=="docs/quick"?"class=\"current-menu-item\"":""); ?>><a href="/docs/quick">QUICK START</a></li>
    <li <? echo(getRoute()=="api"?"class=\"current-menu-item\"":""); ?>><a href="/api">API</a></li>
    <li <? echo(getRoute()=="get-involved"?"class=\"current-menu-item\"":""); ?>><a href="/get-involved">GET INVOLVED</a>
      <ul>
        <li><a href="/contribute">CONTRIBUTE</a></li>
        <li><a href="/submit">SUBMIT</a></li>
      </ul>
    </li>
    <li><a href="/blog">BLOG</a></li>
    <li><a href="/contact">SUPPORT</a>
      <ul>
        <li><a href="/faq">FAQ</a></li>
        <li><a href="/contact">CONTACT</a></li>
        <li><a href="/about">ABOUT</a></li>
      </ul>
    </li>
  </ul>
</nav>

<nav class="mobile-menu">
  <ul>
    <li><a href="/">HOME</a></li>
    <li><a href="/docs/quick">QUICK START</a></li>
    <li><a href="/api">API</a></li>
    <li><a href="/get-involved">GET INVOLVED</a>
      <ul>
        <li><a href="/contribute">CONTRIBUTE</a></li>
        <li><a href="/submit">SUBMIT</a></li>
      </ul>
    </li>
    <li><a href="/blog">BLOG</a></li>
    <li><a href="/contact">SUPPORT</a>
      <ul>
        <li><a href="/faq">FAQ</a></li>
        <li><a href="/contact">CONTACT</a></li>
        <li><a href="/about">ABOUT</a></li>
      </ul>
    </li>
  </ul>
</nav>