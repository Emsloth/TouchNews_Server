<!DOCTYPE html>
<html>
<head>
</head>
<body>
<p>
some words
Returns <p>an element with namespace namespace.</p> Its namespace prefix will be everything before ":" (U+003E) in qualifiedName or null. Its local name will be everything after ":" (U+003E) in qualifiedName or qualifiedName.
If localName does <p>not match</p> <p>the Name </p>production an InvalidCharacterError will be thrown.
some words Returns an element with <strong>namespace namespace.</strong> Its namespace prefix will be everything before ":" (U+003E) in qualifiedName or null. Its local name will be everything after ":" (U+003E) in qualifiedName or qualifiedName. If localName does not match the Name production an InvalidCharacterError will be thrown. If one of the following conditions is true a NamespaceError will be thrown: localName does not match the QName production. Namespace prefix is not null and namespace is the empty string. Namespace prefix is "xml" and namespace is not the XML namespace. qualifiedName or namespace prefix is "xmlns" and namespace is not the XMLNS namespace. namespace is the XMLNS namespace and neither qualifiedName nor namespace prefix is "xmlns". When supplied, options�� is member can be used to create a customized built-in element.

</p>
<script>
(function(){
document.getElementsByTagName('body')[0].className+=' clickable';

var css = '.clicked { color : #80ff00; background-color: lightblue; }';
var styleTag = document.createElement("style");
var node = document.createTextNode(css);
styleTag.appendChild(node);
document.getElementsByTagName('head')[0].appendChild(styleTag);

var loadJqueryTag = document.createElement("script");
loadJqueryTag.src = "http://emsloth.vps.phps.kr/jquery.min.js"; 
document.getElementsByTagName('head')[0].appendChild(loadJqueryTag);

var scriptTag   = document.createElement("script");
//scriptTag.src   = "http://emsloth.vps.phps.kr/tF.js";

scriptTag.src   = "http://emsloth.vps.phps.kr/textSelectFunction.js"; 
document.getElementsByTagName('head')[0].appendChild(scriptTag);

}());

</script>

</body>
</html>

