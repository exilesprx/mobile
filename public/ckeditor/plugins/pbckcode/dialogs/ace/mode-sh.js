﻿define("ace/mode/sh","require exports module ace/lib/oop ace/mode/text ace/tokenizer ace/mode/sh_highlight_rules ace/range".split(" "),function(a,h){var i=a("../lib/oop"),j=a("./text").Mode,g=a("../tokenizer").Tokenizer,m=a("./sh_highlight_rules").ShHighlightRules,l=a("../range").Range,k=function(){this.$tokenizer=new g((new m).getRules())};i.inherits(k,j);(function(){this.toggleCommentLines=function(f,b,c,d){for(var e=true,f=/^(\s*)#/,a=c;a<=d;a++)if(!f.test(b.getLine(a))){e=false;break}if(e){e=
new l(0,0,0,0);for(a=c;a<=d;a++){c=b.getLine(a).match(f);e.start.row=a;e.end.row=a;e.end.column=c[0].length;b.replace(e,c[1])}}else b.indentRows(c,d,"#")};this.getNextLineIndent=function(a,b,c){var d=this.$getIndent(b),e=this.$tokenizer.getLineTokens(b,a).tokens;if(e.length&&e[e.length-1].type=="comment")return d;a=="start"&&b.match(/^.*[\{\(\[\:]\s*$/)&&(d=d+c);return d};var a={pass:1,"return":1,raise:1,"break":1,"continue":1};this.checkOutdent=function(f,b,c){if(c!=="\r\n"&&c!=="\r"&&c!=="\n")return false;
f=this.$tokenizer.getLineTokens(b.trim(),f).tokens;if(!f)return false;do b=f.pop();while(b&&(b.type=="comment"||b.type=="text"&&b.value.match(/^\s+$/)));return b?b.type=="keyword"&&a[b.value]:false};this.autoOutdent=function(a,b,c){var c=c+1,a=this.$getIndent(b.getLine(c)),d=b.getTabString();a.slice(-d.length)==d&&b.remove(new l(c,a.length-d.length,c,a.length))}}).call(k.prototype);h.Mode=k});
define("ace/mode/sh_highlight_rules",["require","exports","module","ace/lib/oop","ace/mode/text_highlight_rules"],function(a,h){var i=a("../lib/oop"),j=a("./text_highlight_rules").TextHighlightRules,g=function(){this.$rules={start:[{token:"comment",regex:"#.*$"},{token:"string",regex:'"(?:[^\\\\]|\\\\.)*?"'},{token:"variable.language",regex:"(?:\\$(?:SHLVL|\\$|\\!|\\?))"},{token:"variable",regex:"(?:(?:\\$[a-zA-Z][a-zA-Z0-9_]*)|(?:[a-zA-Z][a-zA-Z0-9_]*=))"},{token:"support.function",regex:"(?:[a-zA-Z][a-zA-Z0-9_]*\\s*\\(\\))"},
{token:"support.function",regex:"(?:&(?:\\d+))"},{token:"string",regex:"'(?:[^\\\\]|\\\\.)*?'"},{token:"constant.numeric",regex:"(?:(?:(?:(?:(?:(?:\\d+)?(?:\\.\\d+))|(?:(?:\\d+)\\.))|(?:\\d+)))|(?:(?:(?:\\d+)?(?:\\.\\d+))|(?:(?:\\d+)\\.)))"},{token:"constant.numeric",regex:"(?:(?:[1-9]\\d*)|(?:0))\\b"},{token:this.createKeywordMapper({keyword:"!|{|}|case|do|done|elif|else|esac|fi|for|if|in|then|until|while|&|;|export|local|read|typeset|unset|elif|select|set","constant.language":"[|]|alias|bg|bind|break|builtin|cd|command|compgen|complete|continue|dirs|disown|echo|enable|eval|exec|exit|fc|fg|getopts|hash|help|history|jobs|kill|let|logout|popd|printf|pushd|pwd|return|set|shift|shopt|source|suspend|test|times|trap|type|ulimit|umask|unalias|wait",
"invalid.deprecated":"debugger"},"identifier"),regex:"[a-zA-Z_$][a-zA-Z0-9_$]*\\b"},{token:"keyword.operator",regex:"\\+|\\-|\\*|\\*\\*|\\/|\\/\\/|~|<|>|<=|=>|=|!="},{token:"paren.lparen",regex:"[\\[\\(\\{]"},{token:"paren.rparen",regex:"[\\]\\)\\}]"},{token:"text",regex:"\\s+"}]}};i.inherits(g,j);h.ShHighlightRules=g});