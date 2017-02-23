console.log('thalia mae');
// var figs = document.getElementsByTagName('figure');
// var figsLen = figs.length;
var figTemp = document.getElementById('fig-temp-container');
var figCont = document.getElementById('fig-container');
var figHolder = document.getElementById('fig-holder');
var imgsExist = true;

var i = 1;
var imgPath = ['./img/upload/tm-', '-c.jpg'];
var imgTimeout;

// LOOP THROUGH LOADING IMAGES
function figsLoad() {

  // TEST IMG PATH BY ADDING TO HIDDEN IMG TAG
  figHolder.src = imageName(i);
  console.log(imageName(i));

  figHolder.onload = function() {
    // UNTIL FLAG IS SET TO FALSE ON IMG LOAD ERROR
    if (imgsExist) {

      imgTimeout = setTimeout(function() {

        var itm = figTemp.getElementsByTagName('figure')[0];
        var cln = itm.cloneNode(true);

        cln.getElementsByClassName('img')[0].style.backgroundImage = 'url("' + imageName(i) + '")';
        cln.getElementsByClassName('img')[0].href = imageName(i);

        figCont.appendChild(cln);
        figCont.getElementsByTagName('figure')[i].add('show');

        i++;

        // REPEAT
        figsLoad();

      },170);

    }    
  }

  // IF PATH TURNS UP ERROR, NO MORE IMGS EXIST
  figHolder.onerror = function() {
    clearTimeout(imgTimeout);
    imgsExist = false;
    console.log((i-1) + ' total' + '\nend loading imgs');
  }



}

// CREATE IMAGE NAMES FROM TEMPLATE
var imageName = function imageName(input) {

  var number = input.toString();
  // CONVERT TO 4 DIGITS
  if (number.length === 1) { number = '000' + number.toString();}
  else if (number.length === 2) { number = '00' + number.toString(); }
  else if (number.length === 3) { number = '0' + number.toString(); }

  return imgPath[0] + number + imgPath[1];
};

window.onload = function() {
  console.log('window.onload');

  setTimeout(function() {
    document.getElementById('loader').classList.add('hide');
    console.log('start loading imgs...');

    figsLoad();
  },200);
}

var touchEvent = 'ontouchstart' in window ? 'touchstart' : 'click';
var modalUlOpen = false;
var modalUl = document.getElementById('modal-upload');
var containerBgBlur = document.getElementById('container-blur');

// OPEN UPLOAD MODAL VIA BTN
document.getElementById('btn-upload').addEventListener(touchEvent, function() {
  modalUlOpen ? (
		// fadeOut(modalUl),
    modalUl.classList.remove('show'),
		modalUlOpen = false,
		containerBgBlur.classList.remove('active')
		) : (
		// fadeIn(modalUl),
    modalUl.classList.add('show'),
		modalUlOpen = true,
		containerBgBlur.classList.add('active')
		);

  // STOP PROP FOR CHILD
  modalUl.getElementsByClassName('modal-inner')[0].addEventListener(touchEvent, function(event) {
    event.stopPropagation();
  });

});

// CLOSE MODAL W/ CONTAINER CLICK
modalUl.addEventListener(touchEvent, function() {
  // fadeOut(modalUl);
  modalUl.classList.remove('show'),
  modalUlOpen = false;
	containerBgBlur.classList.remove('active');
});

// SEND UPLOAD FORM VIA FAKE BTN
document.getElementById('ul-i-btn').addEventListener(touchEvent, function() {
  document.getElementById('form-upload').submit();
});

// FILE SELECTOR ENHANCEMENT
var inputs = document.querySelectorAll( '.input-file' );
Array.prototype.forEach.call( inputs, function( input )
{
  var label  = input.nextElementSibling,
    labelVal = label.innerHTML;

  input.addEventListener( 'change', function( e )
  {
    var fileName = '';
    if( this.files && this.files.length > 1 )
      fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
    else
      fileName = e.target.value.split( '\\' ).pop();

    if( fileName )
      label.querySelector( 'div' ).innerHTML = fileName;
    // label.getElementById('ul-i-file-text').innerHTML = fileName;
    else
      label.innerHTML = labelVal;
  });
});

window.onscroll = function() {
  var top = window.pageYOffset;
	if (top > 1 && top < 300) {
    document.getElementsByTagName('header')[0].classList.add('scroll');
  }
  else if (top < 1) {
    document.getElementsByTagName('header')[0].classList.remove('scroll');
  }
};

// fade out
function fadeOut(el){
  el.style.opacity = 1;

  (function fade() {
    if ((el.style.opacity -= .1) < 0) {
      el.style.display = "none";
    } else {
      requestAnimationFrame(fade);
    }
  })();
}

// fade in
function fadeIn(el, display){
  el.style.opacity = 0;
  el.style.display = display || "block";

  (function fade() {
    var val = parseFloat(el.style.opacity);
    if (!((val += .1) > 1)) {
      el.style.opacity = val;
      requestAnimationFrame(fade);
    }
  })();
}
