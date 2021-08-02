// ********************************************************************************************
// Title          udde Instant Messages (uddeIM)
// Description    Instant Messages System for Mambo 4.5 / Joomla 1.0 / Joomla 1.5
// Author         © 2007-2008 Stephan Slabihoud
// License        This is free software and you may redistribute it under the GPL.
//                uddeIM comes with absolutely no warranty.
//                Use at your own risk. For details, see the license at
//                http://www.gnu.org/licenses/gpl.txt
//                Other licenses can be found in LICENSES folder.
//                Redistributing this file is only allowed when keeping the header unchanged.
// ********************************************************************************************

var uddeimW3CDOM = (document.createElement && document.getElementsByTagName);

function textCount(field,counterfield,max) {
	if (field.value.length > max) // if too long...trim it!
		field.value = field.value.substring(0, max);
	else
	counterfield.value = max - field.value.length;
}
function wiglwogl(uddeElement) { 
	uddeForm = uddeElement.form; 
	uddeElement = uddeForm.elements[uddeElement.name]; 
	if (uddeElement.length) { 
		bChecked = uddeElement[0].checked; 
		for(i = 1; i < uddeElement.length; i++) 
			uddeElement[i].checked = bChecked; 
	} 
} 
function inboxDelete(url) {
	document.messages.action = url;
	document.messages.submit();
}
function outboxDelete(url) {
	document.messages.action = url;
	document.messages.submit();
}
function archiveDownload(url) {
	document.messages.action = url;
	document.messages.submit();
}
function archiveTrash(url) {
	document.messages.action = url;
	document.messages.submit();
}
function listsDelete(url) {
	document.messages.action = url;
	document.messages.submit();
}
function uddeidswap(id) {
	bb = document.getElementById(id);
	if (bb.style.visibility == 'visible') {
		bb.style.visibility = 'hidden';
	} else {
		bb.style.visibility = 'visible';
	}
}

function uddeIMaddToSelection( frmName, srcListName, tgtListName, maxOnList ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );
	var tgtList = eval( 'form.' + tgtListName );
	
	var destinationIds = eval( 'document.' + frmName + '.listids' );

	var srcLen = srcList.length;
	var tgtLen = tgtList.length;
	var tgt = "x";

	var idjoin = new Array();
	
	//build array of target items
	for ( var i=tgtLen-1; i > -1; i-- ) {
		tgt += "," + tgtList.options[i].value + ","
	}

	//Pull selected resources and add them to list	
//	for ( var i=0; i < srcLen; i++ ) {
	for ( var i=srcLen-1; i >= 0; i-- ) {
		if ( tgtList.length<maxOnList && srcList.options[i].selected && tgt.indexOf( "," + srcList.options[i].value + "," ) == -1 ) {
			if ( srcList.options[i].value == 0 || ( tgtLen != 0 && tgtList.options[0].value == 0 ) ) {
				for ( var j = tgtLen-1; j > -1; j-- ) {
					tgtList.options[j] = null;						
				}
			} 
//			var textto_ar = srcList.options[i].text.split('‹');
//			opt = new Option( textto_ar[0], srcList.options[i].value );
			opt = new Option( srcList.options[i].text, srcList.options[i].value );
			tgtList.options[tgtList.length] = opt;
			srcList.options[i] = null;
		}
	}

	// now remove these entries from the source list
//	for ( var i=srcLen-1; i > -1; i-- ) {
//		if ( srcList.options[i].selected ) {
//			srcList.options[i] = null;
//		}
//	}

	// collect all IDs from the target list
	for ( var i=0; i < tgtList.length; i++ ) {
		idjoin[i] = tgtList.options[i].value;						
	}
	destinationIds.value = idjoin.join( ',' );
}

function uddeIMremoveFromSelection( frmName, srcListName, tgtListName, maxOnList ) {
	var form = eval( 'document.' + frmName );
	var srcList = eval( 'form.' + srcListName );
	var tgtList = eval( 'form.' + tgtListName );
	
	var destinationIds = eval( 'document.' + frmName + '.listids' );
	var idjoin = new Array();

	var srcLen = srcList.length;

	for ( var i=srcLen-1; i > -1; i-- ) {
		if ( srcList.options[i].selected ) {
			// add removed entry to dest list again
			opt = new Option( srcList.options[i].text, srcList.options[i].value );
			tgtList.options[tgtList.length] = opt;

			srcList.options[i] = null;
			// break;	- remove all selected entries
		}
	}
	
	for ( var i=0; i < srcList.length; i++ ) {
		idjoin[i] = srcList.options[i].value;						
	}
	destinationIds.value = idjoin.join( ',' );
}

function userlistdblclick( sel, frmName, srcListName, tgtListName, maxOnList ) {
	uddeIMaddToSelection( frmName, srcListName, tgtListName, maxOnList );
}
function selectionlistdblclick( sel, frmName, srcListName, tgtListName, maxOnList ) {
	uddeIMremoveFromSelection( frmName, srcListName, tgtListName, maxOnList );
}

function uddeIMtoggleLayer(itemID) {
  if (document.getElementById('uddeimdivlayer_'+itemID).style.display=='none')
	document.getElementById('uddeimdivlayer_'+itemID).style.display = 'inline';
  else
	document.getElementById('uddeimdivlayer_'+itemID).style.display = 'none';
}

function uddeIMtoggleLayer2(itemID) {
  if (document.getElementById('uddeimdivlayer_'+itemID).style.display=='none') {
	document.getElementById('uddeimdivlayerpreview_'+itemID).style.display = 'none';
	document.getElementById('uddeimdivlayer_'+itemID).style.display = 'inline';
  } else {
	document.getElementById('uddeimdivlayer_'+itemID).style.display = 'none';
	document.getElementById('uddeimdivlayerpreview_'+itemID).style.display = 'inline';
  }
}
