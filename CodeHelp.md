# Introduction #

Sorry for the confusing code, here is a little code documentation.


# Details #

Add your content here.  Format your content with:
  * Text in **bold** or _italic_
  * Headings, paragraphs, and lists
  * Automatic links to other wiki pages

All commands in my framework start with **$this->** and, as you can probably see, it's in a class.
Commands:

**$this->Parse()** get current page's content and put it in the page.

**$this->CD()** I think this gets the current directory (windows only I think, maybe, I don't know)

**$this->dir($bool = false)** same as above, I think.

**$this->getFunction()** get the current page function, ex. /pagename.html/function/parameters

**$this->getParameters()** get the current page parameters, ex. /pagename.html/function/parameters

**$this->getScriptUrl()** Deprecated, use below.

**$this->getBasePath()** Get the entire scripts directory/install dir.

**$this->curPageURL()** Get's full current URL, Used in error pages.

**$this->title($tl)** Title of page,
  * _page_ not implemented
  * _site_ grabs the $SiteTitle variable from the config file

**$this->themePath()** gets the current theme's directory and returns it.