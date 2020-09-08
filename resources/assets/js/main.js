// window.docsearch = require('docsearch.js');

import Prism from 'prismjs'
import animate from 'animateplus'

window.animate = animate

// Load languages.
import 'prismjs/components/prism-markup'
import 'prismjs/components/prism-markup-templating'
import 'prismjs/components/prism-clike'
import 'prismjs/components/prism-bash'
import 'prismjs/components/prism-json'
import 'prismjs/components/prism-php'
import 'prismjs/plugins/line-highlight/prism-line-highlight.js'
// import 'prismjs/plugins/line-highlight/prism-line-highlight.css'

Prism.highlightAll();
