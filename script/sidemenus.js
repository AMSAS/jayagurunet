var ContentHeight = 390;
var TimeToSlide = 250.0;

var openAccordion = '';

function runAccordion(index)
{
  var nID = "Accordion" + index + "Content";
  if(openAccordion == nID)
    nID = '';

  setTimeout("animate(" + new Date().getTime() + "," + TimeToSlide + ",'" + openAccordion + "','" + nID + "')", 33);

  openAccordion = nID;
}

function animate(lastTick, timeLeft, closingId, openingId)
{
  var curTick = new Date().getTime();
  var elapsedTicks = curTick - lastTick;

  var opening = (openingId == '') ? null : document.getElementById(openingId);
  var closing = (closingId == '') ? null : document.getElementById(closingId);

  if(timeLeft <= elapsedTicks)
  {
    if(opening != null)
      opening.style.height = ContentHeight + 'px';

    if(closing != null)
    {
      closing.style.display = 'none';
      closing.style.height = '0px';
    }
    return;
  }

  timeLeft -= elapsedTicks;
  var newClosedHeight = Math.round((timeLeft/TimeToSlide) * ContentHeight);

  if(opening != null)
  {
    if(opening.style.display != 'block')
      opening.style.display = 'block';
    opening.style.height = (ContentHeight - newClosedHeight) + 'px';
  }

  if(closing != null)
    closing.style.height = newClosedHeight + 'px';

  setTimeout("animate(" + curTick + "," + timeLeft +",'" + closingId + "','" + openingId + "')", 33);
}

var opt_array = ['Thakura', 'Biography', 'Philosophy', 'Gospels', 'Publication', 'Organization', 'About Us', 'Asana Mandira in America',
                 'Nilachala Saraswata Sangha', 'Saraswata Matha'];

function defineMenu() {
  document.write('<div><div class="AccordionTitle" onclick="runAccordion(1);" onselectstart="return false;"><img src="../images/white.gif" /> ShriShri Thakura</div></div>');
  document.write('<div id="Accordion1Content" class="AccordionContent">');
  document.write('<img  src="../images/123.jpg" height="201" width="170"/><br/>Paramahansha <br/>Srimatswami Nigamananda Saraswati Dev</a><br/><br/>');
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[1]+'" >'+menuItems[1]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[2]+'" >'+menuItems[2]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[3]+'">'+menuItems[3]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[4]+'" >'+menuItems[4]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[9]+'">'+menuItems[9]+'</a></li>');
  document.write('</ul>');
  document.write('</div>');
  document.write('<div><div class="AccordionTitle" onclick="runAccordion(2);" onselectstart="return false;"><img src="../images/white.gif" /> Organization</div></div>');
  document.write('<div id="Accordion2Content" class="AccordionContent">');
  document.write('<img  src="../images/124.gif" height="170" width="170"/><br/><br/>');
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[10]+'">'+menuItems[10]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[8]+'">'+menuItems[8]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[9]+'">'+menuItems[9]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[6]+'">'+menuItems[6]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[7]+'">'+menuItems[7]+'</a></li>');
  document.write('</ul>');
  document.write('</div>');
  document.write('<div><div class="AccordionTitle" onclick="runAccordion(3);" onselectstart="return false;"><img src="../images/white.gif" /> Community Giving</div></div>');
  document.write('<div id="Accordion3Content" class="AccordionContent">');
  document.write('<img  src="../images/125.gif" height="147" width="220"/><br/><br/>');
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[29]+'">'+menuItems[29]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[30]+'">'+menuItems[30]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[31]+'">'+menuItems[31]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[32]+'">'+menuItems[32]+'</a></li>');
  document.write('</ul>');
  document.write('</div>');
  document.write('<div><div class="AccordionTitle" onclick="runAccordion(4);" onselectstart="return false;"><img src="../images/white.gif" /> Events</div></div>');
  document.write('<div id="Accordion4Content" class="AccordionContent">');
  document.write('<img  src="../images/125.gif" height="147" width="220"/><br/><br/>');
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[14]+'">'+menuItems[14]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[13]+'">'+menuItems[13]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[12]+'">'+menuItems[12]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[15]+'">'+menuItems[15]+'</a></li>');
  document.write('</ul>');
  document.write('</div>');
  document.write('<div><div class="AccordionTitle" onclick="runAccordion(5);" onselectstart="return false;"><img src="../images/white.gif" /> Members</div></div>');
  document.write('<div id="Accordion5Content" class="AccordionContent" >');
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[17]+'" >'+menuItems[17]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[18]+'">'+menuItems[18]+'</a></li>');
  //document.write('<li><a href="'+linkHome+menuLinks[19]+'">'+menuItems[19]+'</a></li>');
  //document.write('<li><a href="'+linkHome+menuLinks[20]+'">'+menuItems[20]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[21]+'">'+menuItems[21]+'</a></li>');
  //document.write('<li><a href="'+linkHome+menuLinks[22]+'">'+menuItems[22]+'</a></li>');
  //document.write('<li><a href="'+linkHome+menuLinks[23]+'">'+menuItems[23]+'</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[24]+'">'+menuItems[24]+'</a></li>');
  document.write('</ul>');
  document.write('</div>');
}

function topmenu() {
document.write('<div class="rightmenu" id="chromemenu">');
document.write('<ul>');
document.write('<li><a href="'+linkHome+menuLinks[1]+'" rel="dropmenu1">'+menuItems[1]+'</a></li>');
document.write('<li><a href="'+linkHome+menuLinks[5]+'" rel="dropmenu2">'+menuItems[5]+'</a></li>');
document.write('<li><a href="'+linkHome+menuLinks[28]+'" rel="dropmenu3">'+menuItems[28]+'</a></li>');
document.write('<li><a href="'+linkHome+menuLinks[11]+'" rel="dropmenu4">'+menuItems[11]+'</a></li>');
document.write('<li><a href="'+linkHome+menuLinks[16]+'" rel="dropmenu5">'+menuItems[16]+'</a></li>');
document.write('</ul>');
document.write('</div>');
/*--1st drop down menu --*/
document.write('<div id="dropmenu1" class="dropmenudiv" style="width: 200px;">');
document.write('<a href="'+linkHome+menuLinks[2]+'">'+menuItems[2]+'</a>');
document.write('<a href="'+linkHome+menuLinks[3]+'">'+menuItems[3]+'</a>');
document.write('<a href="'+linkHome+menuLinks[4]+'">'+menuItems[4]+'</a>');
document.write('<a href="'+linkHome+menuLinks[9]+'">'+menuItems[9]+'</a>');
document.write('</div>');
/*--2nd drop down menu --*/
document.write('<div id="dropmenu2" class="dropmenudiv" style="width: 200px;">');
document.write('<a href="'+linkHome+menuLinks[10]+'">'+menuItems[10]+'</a>');
document.write('<a href="'+linkHome+menuLinks[8]+'">'+menuItems[8]+'</a>');
document.write('<a href="'+linkHome+menuLinks[9]+'">'+menuItems[9]+'</a>');
document.write('<a href="'+linkHome+menuLinks[6]+'">'+menuItems[6]+'</a>');
document.write('<a href="'+linkHome+menuLinks[7]+'">'+menuItems[7]+'</a>');
document.write('</div>');
/*--3rd drop down menu --*/
document.write('<div id="dropmenu3" class="dropmenudiv" style="width: 200px;">');
document.write('<a href="'+linkHome+menuLinks[29]+'">'+menuItems[29]+'</a>');
document.write('<a href="'+linkHome+menuLinks[30]+'">'+menuItems[30]+'</a>');
document.write('<a href="'+linkHome+menuLinks[31]+'">'+menuItems[31]+'</a>');
document.write('<a href="'+linkHome+menuLinks[32]+'">'+menuItems[32]+'</a>');
document.write('</div>');
/*--4th drop down menu --*/
document.write('<div id="dropmenu4" class="dropmenudiv" style="width: 200px;">');
document.write('<a href="'+linkHome+menuLinks[14]+'">'+menuItems[14]+'</a>');
document.write('<a href="'+linkHome+menuLinks[13]+'">'+menuItems[13]+'</a>');
document.write('<a href="'+linkHome+menuLinks[12]+'">'+menuItems[12]+'</a>');
document.write('<a href="'+linkHome+menuLinks[15]+'">'+menuItems[15]+'</a>');
document.write('</div>');
/*--5th drop down menu --*/
document.write('<div id="dropmenu5" class="dropmenudiv" style="width: 200px;">');
document.write('<a href="'+linkHome+menuLinks[17]+'">'+menuItems[17]+'</a>');
document.write('<a href="'+linkHome+menuLinks[18]+'">'+menuItems[18]+'</a>');
//document.write('<a href="'+linkHome+menuLinks[19]+'">'+menuItems[19]+'</a>');
//document.write('<a href="'+linkHome+menuLinks[20]+'">'+menuItems[20]+'</a>');
document.write('<a href="'+linkHome+menuLinks[21]+'">'+menuItems[21]+'</a>');
//document.write('<a href="'+linkHome+menuLinks[22]+'">'+menuItems[22]+'</a>');
//document.write('<a href="'+linkHome+menuLinks[23]+'">'+menuItems[23]+'</a>');
document.write('<a href="'+linkHome+menuLinks[24]+'">'+menuItems[24]+'</a>');
document.write('</div>');
}

function footLinksLeft() {
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[26]+'">About Us</a></li>');
  document.write('<li><a href="mailto:amsas@jayaguru.net">Contact Us</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[27]+'">Site Map</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[28]+'">Community Giving</a></li>');
  document.write('</ul>');
}
function footLinksCenter() {
  document.write('<img src="'+linkHome+'images/footcen.gif" height="85" width="375">');

}
function footLinksRight() {
  document.write('<ul>');
  document.write('<li><a href="'+linkHome+menuLinks[25]+'">Prayers</a></li>');
/*  document.write('<li><a href="#">Adi Shankaracharya</a></li>');
  document.write('<li><a href="#">Shri Gourang Dev</a></li>');*/
  document.write('<li><a href="'+linkHome+menuLinks[11]+'">Sammilani (The Congregation)</a></li>');
  document.write('<li><a href="'+linkHome+menuLinks[17]+'">Sangha Puja</a></li>');
  document.write('</ul>');
}

function footCenter() {
  document.write('<table border="0" width="1004" height="130" cellpadding="0" cellspacing="0">');
  document.write('<tr>');
  document.write('<td width="302" >');
  footLinksLeft();
  document.write('</td>');
  document.write('<td width="400" align="left" >');
  footLinksCenter();
  document.write('</td>');
  document.write('<td width="302" align="left" >');
  footLinksRight();
  document.write('</td>');
  document.write('</td>');
  document.write('</tr>');
  document.write('</table>');
}

function copyRight() {
  document.write('<font face="Arial Unicode MS" size="1" color="303030">(c) Copyright 2014 America Saraswata Sangha</font>');
}


function headerLeft() {
  //document.write('<IMG SRC="'+linkHome+'/images/ltbanr01.gif" width="375" height="85" align="top" alt="ABSM/NSS/AMSAS Banner"> </IMG>');
}

function headerRight() {
  //swapimage();
}

function swapimage() {
  theimages = new Array("rtbanr01.gif", "rtbanr02.gif");
  whichimage = Math.floor(Math.random()*theimages.length);
  document.write('<IMG SRC="'+linkHome+'/images/' +theimages[whichimage]+
                 '" width="375" height="85" align="top" alt="ABSM/NSS/AMSAS Banner"> </IMG>');
}


function getLink(text) {
    var flag = 0;
    var ft = " ";
    for (var i=0; i<menuItems.length; i++) {
	  // remove one line breaker
	  var mi = menuItems[i];
	  /*var end = (mi.indexOf("<br/>") == -1) ? mi.length : mi.indexOf("<br/>");
	  if (end < mi.length-1) {
	    ft = mi.substring(0, mi.lastIndexOf("<br/>"));
		ft = ft + mi.substring(mi.lastIndexOf("<br/>")+5, mi.length);
	  }
	  else {ft = mi;}*/
	  if (text == mi) {
	    document.write('<a href="'+linkHome+menuLinks[i]+'">'+text+'</a>');
		flag = 1;
		break;
	  }
	}
    if (flag==0) document.write('?'+text+'?');
}

function getsouv(path) {
  var styr = 2002, enyr = 2015;
  // document.write('<SELECT NAME="choice" onchange="window.location.href=this.options[this.selectedIndex].value;">');
  document.write('<SELECT NAME="madhuri" >');
  document.write('<OPTION SELECTED VALUE="#">Select year');
  for (var i=enyr; i>=styr; i--) {
   document.write('<OPTION VALUE="'+path+'/madhuri/Saraswata_Madhuri_' + i + '.pdf">' + i);
  }
  document.write('</SELECT>');
  document.write('&nbsp;&nbsp;<INPUT type="button" value="Get" onclick="window.location.href=madhuri.options[madhuri.selectedIndex].value;"/>');
}


var menuItems=['Home',
        'Shri Shri Thakura',
           'Biography',
           'Philosophy',
           'Gospels',
        'Organization',
           'America Saraswata Sangha',
           'Asana Mandira in America',
           'Nilachala Saraswata Sangha',
           'Saraswata Publications',
           'Saraswata Matha',
        'Events',
           'Sarbabhouma Sammilani',
		   'Pradeshika Sammilani',
		   'America Sammilani',
           'Annual Festivals',
        'Members',
           'Sangha Puja',
           'Next Sangha Puja',
           'Young Aspirants Sangha Puja',
           'Next YA Sangha Puja',
           'Special Sangha Puja Sessions',
		   'Sashtrapatha Puja',
		   'Mahila Sangha Puja',
           'Member References',
		'Prayer',
		'About Us',
		'Site Map',
		'Community Giving',
			'Recent News',
			'Special Interests',
			'International Giving',
			'Our Focus'];

// menu Item links with respect to items in menuItem array
var linkHome = new String('/');
//var linkHome = new String('http://localhost:8080/');

var menuLinks=['',
        'shri_shri_thakura',
           'shri_shri_thakura/biography',
           'shri_shri_thakura/philosophy',
           'shri_shri_thakura/gospels',
        'organization',
           'organization/america_saraswata_sangha',
	       'organization/asana_mandira',
           'organization/nilachala_saraswata_sangha',
           'organization/publications',
		   'organization/saraswata_matha',
        'events',
			'events/sarbabhouma_sammilani',
			'events/pradeshika_sammilani',
			'events/america_bhakta_sammilani',
			'members/special_sanghapuja',
        'members',
           'members/sangha_puja',
	       'members/next_sangha_puja',
           'members/young_aspirants_sanghapuja',
		   'members/ya_nextpuja',
		   'members/special_sanghapuja',
		   'members/sastrapatha_and_mahilapuja',
		   'members/sastrapatha_and_mahilapuja#mahila',
		   'members/member_references',
		'references/prayer',
		'organization/america_saraswata_sangha',
		'site_map.html',
		'community_giving',
			'community_giving/recent_news',
			'community_giving/special_interests',
			'community_giving/international_giving',
			'community_giving/our_focus'];

function siteMap() {
document.write('<ul>');
document.write('<li><a href="'+linkHome+'">'+menuItems[0]+'</a></li>');
document.write('</ul>');
document.write('<ul>');
document.write('<li><a href="'+linkHome+menuLinks[1]+'">'+menuItems[1]+'</a>');
	document.write('<ul>');
	  document.write('<li><a href="'+linkHome+menuLinks[2]+'">'+menuItems[2]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[3]+'">'+menuItems[3]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[4]+'">'+menuItems[4]+'</a>');
	document.write('</ul>');
document.write('</li>');
document.write('</ul>');
document.write('<ul>');
document.write('<li><a href="'+linkHome+menuLinks[5]+'">'+menuItems[5]+'</a>');
	document.write('<ul>');
	  document.write('<li><a href="'+linkHome+menuLinks[6]+'">'+menuItems[6]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[7]+'">'+menuItems[7]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[28]+'">'+menuItems[28]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[8]+'">'+menuItems[8]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[9]+'">'+menuItems[9]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[10]+'">'+menuItems[10]+'</a>');
	document.write('</ul>');
document.write('</li>');
document.write('</ul>');
document.write('<ul>');
document.write('<li><a href="'+linkHome+menuLinks[11]+'">'+menuItems[11]+'</a>');
	document.write('<ul>');
	  document.write('<li><a href="'+linkHome+menuLinks[12]+'">'+menuItems[12]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[13]+'">'+menuItems[13]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[14]+'">'+menuItems[14]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[15]+'">'+menuItems[15]+'</a>');
	document.write('</ul>');
document.write('</li>');
document.write('</ul>');
document.write('<ul>');
document.write('<li><a href="'+linkHome+menuLinks[16]+'">'+menuItems[16]+'</a>');
	document.write('<ul>');
	  document.write('<li><a href="'+linkHome+menuLinks[17]+'">'+menuItems[17]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[18]+'">'+menuItems[18]+'</a>');
	  //document.write('<li><a href="'+linkHome+menuLinks[19]+'">'+menuItems[19]+'</a>');
	  //document.write('<li><a href="'+linkHome+menuLinks[20]+'">'+menuItems[20]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[21]+'">'+menuItems[21]+'</a>');
	  //document.write('<li><a href="'+linkHome+menuLinks[22]+'">'+menuItems[22]+'</a>');
	  //document.write('<li><a href="'+linkHome+menuLinks[23]+'">'+menuItems[23]+'</a>');
	  document.write('<li><a href="'+linkHome+menuLinks[24]+'">'+menuItems[24]+'</a>');
	document.write('</ul>');
document.write('</li>');
document.write('</ul>');
}

function samiYears() {
  var samyear = window.location.href;
  var lastdot = samyear.lastIndexOf(".");
  var lastdash = samyear.lastIndexOf("_")+1;
  if (lastdash > lastdot) lastdot = samyear.length;
  samyear = samyear.substring(lastdash, lastdot);

  document.write('<FORM METHOD="POST" onReset="history.go(0)">Select year of Sammilani ');
  document.write('<SELECT NAME="syear" onchange="showSammilani(this.value);">');
  document.write('<OPTION  VALUE="current">current');
  for (var i=2015; i>2001; i--) {
    if (i != samyear)
      document.write('<OPTION  VALUE="'+i+'">'+i);
  }
  document.write('</select>');
  document.write('&nbsp;&nbsp;<INPUT type="button" value="View" onclick="showSammilani(syear.value);"/>');
  document.write('</form>');
}

function showSammilani(samyear) {
	if(samyear=='current')
		window.location.href = linkHome+'events/america_bhakta_sammilani';
	else
		window.location.href = linkHome+'events/america_bhakta_sammilani_'+samyear;
}