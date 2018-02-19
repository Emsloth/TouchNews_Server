$(".clickable").click(function(e) {
    s = window.getSelection();

    var range = s.getRangeAt(0);
   // var node = s.focusNode;

    var node = s.anchorNode;
    var newNode = document.createElement("span");
    newNode.setAttribute('class', 'clicked');

    var formerWord;
   
    while(true){
        formerWord = range.toString().trim();
        range.setStart(node, (range.startOffset -1));
        if(formerWord == range.toString().trim()){
            range.setStart(node, (range.startOffset + 1));
            break;
        }
    }

    while(true){
        formerWord = range.toString().trim();
        range.setEnd(node, (range.endOffset + 1));
        if(formerWord == range.toString().trim()){
            range.setEnd(node, (range.endOffset - 1));
            break;
        }
    }
    alert(formerWord);

    //range.surroundContents(newNode);
    alert(formerWord);
    return formerWord;

});


