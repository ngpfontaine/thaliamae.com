console.log('thalia mae');
var figs = document.getElementsByTagName('figure');
var figsLen = figs.length;
var i = 0;

function figsLoad() {
  setTimeout(function() {

    if (i<figsLen) {
      // fadeIn(figs[i]);
      figs[i].classList.add('show');
      // figs[i].getElementsByTagName('figcaption')[0].classList.add('show');
      figsLoad();
      console.log('figs[' + i +']');
    }

    i++;

  },170);
}

window.onload = function() {
  console.log('window.onload');

  setTimeout(function() {
    document.getElementById('loader').classList.add('hide');
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
		fadeOut(modalUl),
		modalUlOpen = false,
		containerBgBlur.classList.remove('active')
		) : (
		fadeIn(modalUl),
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
  fadeOut(modalUl);
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
  console.log(window.pageYOffset);
	if (top > 1 && top < 10) {
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
