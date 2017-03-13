var figs = document.getElementsByTagName('figure');
var figsLen = figs.length;
var figCont = document.getElementById('fig-container');

// GET PAGE NUMBER PARAMETER
var paramP = window.location.toString();
paramP.indexOf('?p=') > -1 ? paramP = paramP.split('?p=')[1] : paramP = '1';

// 
// ONLOAD
//

window.onload = function() {
  console.log('js - window.onload');

  // document.getElementsByTagName('header')[0].classList.add('show');
  
  setTimeout(function() {
    document.getElementById('loader').classList.add('hide');
    if (figsLen > 0) {
      figsLoad(0);
    }
  },200);

}

//
// LOAD IMAGE FIGURES
//

var figsLoad = function figsLoad(inc) {
  if (figsLen > 0) {

    imgTimeout = setTimeout(function() {

      figs[inc].classList.add('show');
      inc++;
      // REPEAT
      if (inc < figsLen) {
        figsLoad(inc);
      }

    },170);

  }
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

// UPLOAD CLOSE BTN
document.getElementById('upload-close').addEventListener(touchEvent, function() {
  modalUl.classList.remove('show'),
  modalUlOpen = false;
  containerBgBlur.classList.remove('active');
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
  document.getElementById('form-upload').submit();

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

// ABOUT CLOSE BTN
document.getElementById('about-close').addEventListener(touchEvent, function() {
  modalAbout.classList.remove('show');
  modalAboutOpen = false;
});

// FILE SELECTOR ENHANCEMENT
var inputs = document.querySelectorAll('.input-file');
Array.prototype.forEach.call(inputs,function(input) {
  var label  = input.nextElementSibling,
    labelVal = label.innerHTML;

  input.addEventListener( 'change', function( e )
  {
    // ENABLE UPLOAD BTN WHEN FILES ADDED
    if (this.files) {
      document.getElementById('ul-i-btn').classList.remove('disabled');
    }
    else {
      document.getElementById('ul-i-btn').classList.add('disabled');
    }
    var fileName = '';
    if ( this.files && this.files.length > 1 ) {
      fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
    }
    else {
      fileName = e.target.value.split( '\\' ).pop();
    }

    if (fileName) {
      label.querySelector( 'div' ).innerHTML = fileName;
    }
    // label.getElementById('ul-i-file-text').innerHTML = fileName;
    else {
      label.innerHTML = labelVal;
    }
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

// 
// PAGE PAWS
// 

pagesNo++;
var contPagin = document.getElementById('container-pagin');
var contPaginPaw = document.getElementById('container-pagin-paw');

for (var i=0; i<(pagesNo-1); i++) {
  var itm = document.getElementById("page-paw-source").lastChild;
  var cln = itm.cloneNode(true);
  contPaginPaw.appendChild(cln);
  contPagin.getElementsByTagName('i')[i].setAttribute('href','https://thaliamae.com?p=' + (pagesNo-1));
  console.log('running paw pagin loop - ' + i);
  if ((i+1) == Number(paramP)) {
    contPagin.getElementsByTagName('i')[i].classList.add('active');
  }
} 
