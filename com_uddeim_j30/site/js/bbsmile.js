// bbCode control by
// subBlue design
// www.subBlue.com
// Changed by/for uddeIM

// Startup variables
var imageTag = false;
var theSelection = false;

// Check for Browser & Platform for PC & IE specific bits
// More details from: http://www.mozilla.org/docs/web-developer/sniffer/browser_type.html
var clientPC = navigator.userAgent.toLowerCase(); // Get client info
var clientVer = parseInt(navigator.appVersion); // Get browser version

var is_ie = ((clientPC.indexOf("msie") != -1) && (clientPC.indexOf("opera") == -1));
var is_nav = ((clientPC.indexOf('mozilla')!=-1) && (clientPC.indexOf('spoofer')==-1)
                && (clientPC.indexOf('compatible') == -1) && (clientPC.indexOf('opera')==-1)
                && (clientPC.indexOf('webtv')==-1) && (clientPC.indexOf('hotjava')==-1));
var is_moz = 0;

var is_win = ((clientPC.indexOf("win")!=-1) || (clientPC.indexOf("16bit") != -1));
var is_mac = (clientPC.indexOf("mac")!=-1);

// Define the bbCode tags
bbcode = new Array();
bbtags = new Array('[b]','[/b]','[i]','[/i]','[u]','[/u]','[color=#ff4040]','[/color]','[color=#40ff40]','[/color]','[color=#4040ff]','[/color]','[size=1]','[/size]','[size=2]','[/size]','[size=3]','[/size]','[size=4]','[/size]','[ul]','[/ul]','[ol]','[/ol]','[img]','[/img]','[url]','[/url]','[li]','[/li]');
imageTag = false;

// Replacement for arrayname.length property
function getarraysize(thearray) {
	for (i = 0; i < thearray.length; i++) {
		if ((thearray[i] == "undefined") || (thearray[i] == "") || (thearray[i] == null))
			return i;
		}
	return thearray.length;
}

// Replacement for arrayname.push(value) not implemented in IE until version 5.5
// Appends element to the array
function arraypush(thearray,value) {
	thearray[ getarraysize(thearray) ] = value;
}

// Replacement for arrayname.pop() not implemented in IE until version 5.5
// Removes and returns the last element of an array
function arraypop(thearray) {
	thearraysize = getarraysize(thearray);
	retval = thearray[thearraysize - 1];
	delete thearray[thearraysize - 1];
	return retval;
}


function emoticon(text) {
	var txtarea = document.sendeform.pmessage;
	text = ' ' + text + ' ';
	if (txtarea.createTextRange && txtarea.caretPos) {
		var caretPos = txtarea.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? caretPos.text + text + ' ' : caretPos.text + text;
		txtarea.focus();
	} else {
		txtarea.value  += text;
		txtarea.focus();
	}
}

function bbfontstyle(bbopen, bbclose) {
   var txtarea = document.postform.message;

   if ((clientVer >= 4) && is_ie && is_win) {
      theSelection = document.selection.createRange().text;
      if (!theSelection) {
         txtarea.value += bbopen + bbclose;
         txtarea.focus();
         return;
      }
      document.selection.createRange().text = bbopen + theSelection + bbclose;
      txtarea.focus();
      return;
   }
   else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
   {
      mozWrap(txtarea, bbopen, bbclose);
      return;
   }
   else
   {
      txtarea.value += bbopen + bbclose;
      txtarea.focus();
   }
   storeCaret(txtarea);
}


function bbstyle(bbnumber) {
	var txtarea = document.sendeform.pmessage;

	// fix SSL: keep cursor in the currect line
	var scrollTop = txtarea.scrollTop;
	
	txtarea.focus();
	donotinsert = false;
	theSelection = false;
	bblast = 0;

	if (bbnumber == -1) { // Close all open tags & default button names
		while (bbcode[0]) {
			butnumber = arraypop(bbcode) - 1;
			txtarea.value += bbtags[butnumber + 1];
			buttext = eval('document.sendeform.addbbcode' + butnumber + '.src');
			eval('document.sendeform.addbbcode' + butnumber + '.src ="' + buttext.substr(0,(buttext.length - 10)) + '.gif"');
		}
		imageTag = false; // All tags are closed including image tags :D
		txtarea.focus();
		// fix SSL: keep cursor in the currect line
		txtarea.scrollTop = scrollTop;
		return;
	}

	if ((clientVer >= 4) && is_ie && is_win)
	{
		theSelection = document.selection.createRange().text; // Get text selection
		if (theSelection) {
			var sluss;
			var theGuy = bbtags[bbnumber] + theSelection + bbtags[bbnumber+1];
			// Add tags around selection
			document.selection.createRange().text = theGuy;
			sluss = sel.text.length;
			sel.Text = theGuy;
			if (theGuy.length > 0) {
				sel.moveStart('character', -theGuy.length + sluss);
			}	
			txtarea.focus();
			theSelection = '';
			// fix SSL: keep cursor in the currect line
			txtarea.scrollTop = scrollTop;
			return;
		}
	}
	else if (txtarea.selectionEnd && (txtarea.selectionEnd - txtarea.selectionStart > 0))
	{
		mozWrap(txtarea, bbtags[bbnumber], bbtags[bbnumber+1]);
		// fix SSL: keep cursor in the currect line
		txtarea.scrollTop = scrollTop;
		return;
	}
	
	// Find last occurance of an open tag the same as the one just clicked
	for (i = 0; i < bbcode.length; i++) {
		if (bbcode[i] == bbnumber+1) {
			bblast = i;
			donotinsert = true;
		}
	}

	if (donotinsert) {		// Close all open tags up to the one just clicked & default button names
		while (bbcode[bblast]) {
				butnumber = arraypop(bbcode) - 1;
				// txtarea.value += bbtags[butnumber + 1];
				pasteAtCursor(txtarea, bbtags[butnumber+1]);
				buttext = eval('document.sendeform.addbbcode' + butnumber + '.src');
				eval('document.sendeform.addbbcode' + butnumber + '.src ="' + buttext.substr(0,(buttext.length - 10)) + '.gif"');
				imageTag = false;
			}
			txtarea.focus();
			// fix SSL: keep cursor in the currect line
			txtarea.scrollTop = scrollTop;
			return;
	} else { // Open tags
	
		if (imageTag && (bbnumber != 24)) {		// Close image tag before adding another
			// txtarea.value += bbtags[25];
			pasteAtCursor(txtarea, bbtags[25]);
			lastValue = arraypop(bbcode) - 1;	// Remove the close image tag from the list
			var jubla=document.sendeform.addbbcode24.src;
			var juble=jubla.substr(0, (jubla.length - 10));
			var jubli=juble+".gif";
			document.sendeform.addbbcode24.src=jubli;
				// Return button back to normal state
			imageTag = false;
		}
		
		// Open tag
		// txtarea.value += bbtags[bbnumber];
		pasteAtCursor(txtarea, bbtags[bbnumber]);
		if ((bbnumber == 24) && (imageTag == false)) imageTag = 1; // Check to stop additional tags after an unclosed image tag
		arraypush(bbcode,bbnumber+1);
		// eval('document.sendeform.addbbcode'+bbnumber+'.value += "*"');
		var imgsrcori=eval('document.sendeform.addbbcode'+bbnumber+'.src');
		var imgsrcnew=imgsrcori.substr(0, (imgsrcori.length - 4));
		imgsrcnew += "_close.gif";
		eval('document.sendeform.addbbcode'+bbnumber+'.src = "'+imgsrcnew+'"');	
		txtarea.focus();
		// fix SSL: keep cursor in the currect line
		txtarea.scrollTop = scrollTop;
		return;
	}
	storeCaret(txtarea);
	// fix SSL: keep cursor in the currect line
	txtarea.scrollTop = scrollTop;
}

// From http://www.massless.org/mozedit/
function mozWrap(txtarea, open, close)
{
	var selLength = txtarea.textLength;
	var selStart = txtarea.selectionStart;
	var selEnd = txtarea.selectionEnd;
	if (selEnd == 1 || selEnd == 2) 
		selEnd = selLength;

	var s1 = (txtarea.value).substring(0,selStart);
	var s2 = (txtarea.value).substring(selStart, selEnd)
	var s3 = (txtarea.value).substring(selEnd, selLength);
	txtarea.value = s1 + open + s2 + close + s3;
	
	var anfangs = s1;
	var endes = s1+open+s2+close;
	var anfang = anfangs.length;
	var ende= endes.length;
	
		txtarea.selectionStart = anfang;
		txtarea.selectionEnd = ende;	
	
	return;
}

// Insert at Claret position. Code from
// http://www.faqts.com/knowledge_base/view.phtml/aid/1052/fid/130
function storeCaret(textEl) {
	if (textEl.createTextRange) textEl.caretPos = document.selection.createRange().duplicate();
}




// Insert emoticons

function emo($e)
{
	// fix SSL: keep cursor in the currect line
	var txtarea = document.sendeform.pmessage;
	var scrollTop = txtarea.scrollTop;

 // document.sendeform.pmessage.value=document.sendeform.pmessage.value+$e;
 pasteAtCursor(document.sendeform.pmessage,$e);
 document.sendeform.pmessage.focus();

	// fix SSL: keep cursor in the currect line
	txtarea.scrollTop = scrollTop;
}

function pasteAtCursor(theGirl, theGuy) {
/* This function is based upon a function in PHPMyAdmin */
/* (C) www.phpmyadmin.net. Changed by/for uddeIM */
/* See http://www.gnu.org/copyleft/gpl.html for license */
	if (document.selection) {
		//IE support
		var sluss;
		theGirl.focus();
		sel = document.selection.createRange();
		sluss = sel.text.length;
		sel.text = theGuy;
		if (theGuy.length > 0) {
			sel.moveStart('character', -theGuy.length + sluss);
		}		
	} else if (theGirl.selectionStart || theGirl.selectionStart == '0') {
		//MOZILLA/NETSCAPE support
		var startPos = theGirl.selectionStart;
		var endPos = theGirl.selectionEnd;
		theGirl.value = theGirl.value.substring(0, startPos) + theGuy + theGirl.value.substring(endPos, theGirl.value.length);
		theGirl.selectionStart = startPos + theGuy.length;
		theGirl.selectionEnd = startPos + theGuy.length;
	} else {
		theGirl.value += theGuy;
	}
}

