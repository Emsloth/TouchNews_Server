$(".clickable").click(function(e) {
    s = window.getSelection();

    var range = s.getRangeAt(0);
   // var node = s.focusNode;

    var node = s.anchorNode;
    var newNode = document.createElement("span");
    newNode.setAttribute('class', 'clicked');

    var formerWord="";
   
    while(true){
        formerWord = range.toString().trim();
        range.setStart(node, (range.startOffset -1));

        //var str = ">The best things in life are free";
        var patt = new RegExp(">");
        //var res = patt.exec(str);
        var res = patt.exec(range.toString().trim());
        if(res == '>'){
            range.setStart(node, (range.startOffset + 1));
            break;
        }
        if(formerWord == range.toString().trim()){
            range.setStart(node, (range.startOffset + 1));
            break;
        }
    }

    while(true){
        formerWord = range.toString().trim();
        range.setEnd(node, (range.endOffset + 1));
	if(res == '<'){
            range.setEnd(node, (range.endOffset - 1));
            break;
        }

        if(formerWord == range.toString().trim()){
            range.setEnd(node, (range.endOffset - 1));
            break;
        }
    }
    
    range.surroundContents(newNode);
    formerWord = range.toString().trim();
    window.android.callback(formerWord);
    return formerWord;

});


