var figs = document.getElementsByTagName('figure');
var figsLen = figs.length;
var figCont = document.getElementById('fig-container');

var i = 0;

window.onload = function() {
  console.log('js - window.onload');

  // document.getElementsByTagName('header')[0].classList.add('show');
  
  setTimeout(function() {
    document.getElementById('loader').classList.add('hide');

    figsLoad();
  },200);

}

// LOOP THROUGH LOADING IMAGES
var figsLoad = function figsLoad() {

  imgTimeout = setTimeout(function() {

    figs[i].classList.add('show');
    i++;
    // REPEAT
    if (i < figsLen) {
      figsLoad();
    }

  },170);

};

// 
// MODALS
// 

var touchEvent = 'ontouchstart' in window ? 'touchstart' : 'click';
var modalUlOpen = false;
var modalUl = document.getElementById('modal-upload');
var containerBgBlur = document.getElementById('container-blur');

var modalAboutOpen = false;
var modalAbout = document.getElementById('modal-about');

// UPLOAD MODAL OPEN/CLOSE
document.getElementById('btn-upload').addEventListener(touchEvent, function() {
  modalUlOpen ? (
    modalUl.classList.remove('show'),
    modalUlOpen = false,
    containerBgBlur.classList.remove('active')
    ) : (
    modalUl.classList.add('show'),
    modalUlOpen = true,
    containerBgBlur.classList.add('active')
    );
  // STOP PROPOGATION FOR CHILD
  modalUl.getElementsByClassName('modal-inner')[0].addEventListener(touchEvent, function(event) {
    event.stopPropagation();
  });

});

// UPLOAD MODAL CLOSE W/ CONTAINER CLICK
modalUl.addEventListener(touchEvent, function() {
  modalUl.classList.remove('show'),
  modalUlOpen = false;
  containerBgBlur.classList.remove('active');
});

// SEND UPLOAD FORM VIA FAKE BTN
document.getElementById('ul-i-btn').addEventListener(touchEvent, function() {
  this.innerHTML = 'Processing <i class="fa fa-spinner loader-spin"></i>';
  setTimeout(function(){
    document.getElementById('form-upload').submit();
  },1000);

});

// ABOUT MODAL OPEN/CLOSE
document.getElementById('btn-about').addEventListener(touchEvent, function() {
  modalAboutOpen ? (
    modalAbout.classList.remove('show'),
    modalAboutOpen = false
    ) : (
    modalAbout.classList.add('show'),
    modalAboutOpen = true
  );
});

document.getElementById('about-close').addEventListener(touchEvent, function() {
  modalAbout.classList.remove('show');
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

// 
// HEADER
// 

window.onscroll = function() {
  var top = window.pageYOffset;
  if (top > 1 && top < 300) {
    document.getElementsByTagName('header')[0].classList.add('scroll');
  }
  else if (top < 1) {
    document.getElementsByTagName('header')[0].classList.remove('scroll');
  }
};

// FADE OUT
// function fadeOut(el){
//   el.style.opacity = 1;

//   (function fade() {
//     if ((el.style.opacity -= .1) < 0) {
//       el.style.display = "none";
//     } else {
//       requestAnimationFrame(fade);
//     }
//   })();
// }

// // FADE IN
// function fadeIn(el, display){
//   el.style.opacity = 0;
//   el.style.display = display || "block";

//   (function fade() {
//     var val = parseFloat(el.style.opacity);
//     if (!((val += .1) > 1)) {
//       el.style.opacity = val;
//       requestAnimationFrame(fade);
//     }
//   })();
// }
