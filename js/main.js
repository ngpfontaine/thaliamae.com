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

    },140);

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

var sendBtnClicked = false;
// SEND UPLOAD FORM VIA FAKE BTN
document.getElementById('ul-i-btn').addEventListener(touchEvent, function() {
  this.innerHTML = 'Processing <i class="fa fa-spinner loader-spin"></i>';
  if (!sendBtnClicked) {
    document.getElementById('form-upload').submit();
    sendBtnClicked = true;    
  }

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
// PAGE PAWS
// 

pagesNo++;
var contPagin = document.getElementById('container-pagin');
var contPaginPaw = document.getElementById('container-pagin-paw');

for (var i=0; i<pagesNo; i++) {
  var itm = document.getElementById("page-paw-source").lastChild;
  var cln = itm.cloneNode(true);
  contPaginPaw.appendChild(cln);

  // ACTIVE PAGE BY NUMBER
  if ((i+1) == Number(paramP)) {
    contPagin.getElementsByTagName('a')[i].getElementsByTagName('i')[0].classList.add('active');
  }
  // SET LINKS
  else {
    contPagin.getElementsByTagName('a')[i].setAttribute('href','https://thaliamae.com?p=' + (i+1));
  }
}

// OVERPULL REFRESH
var pull = document.getElementById('overpull');
var msg = document.getElementById('overpull-msg');
var height = pull.clientHeight;
var cursorClickOffset = 0;
var wOuterH = window.outerHeight;
var wInnerH = window.innerHeight;
var docOffsetH = document.body.offsetHeight;

var maxH = 120;

// TOGGLE DISABLE FOR TOUCHEND
var pullToggle = true;
// HEIGHT SUCCES FLAG FOR TOUCHEND
var pullSuccess = false;

// var touchEvDown = 'ontouchstart' in window ? 'touchstart' : 'mousedown';
// var touchEvUp = 'ontouchend' in window ? 'touchend' : 'mouseup';
// var touchEvMove = 'ontouchmove' in window ? 'touchmove' : 'mousemove';
// FLAG TO SWAP INPUT'S Y POS
var mobile = 'ontouchstart' in window ? true : false;

window.onscroll = function(ev) {

  // HEADER
  var top = window.pageYOffset;
  if (top > 1 && top < 300) {
    document.getElementsByTagName('header')[0].classList.add('scroll');
  }
  else if (top < 1) {
    document.getElementsByTagName('header')[0].classList.remove('scroll');
  }

  // OVERPULL ON MOBILE
  // if (mobile) {
    // SCROLLED TO BOTTOM, ENABLE
    if ((window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
      document.addEventListener('touchstart', pullOnHandler);
      document.addEventListener('touchend', pullOffHandler);
    }
    // DISABLE/REMOVE EVENTS
    else {
      pullToggle = false;
      document.removeEventListener('touchstart', pullOnHandler);
      document.removeEventListener('touchend', pullOffHandler);
    }
  // }

};

// 
// OVERPULL
// 

// TAKE INPUT, CALCULATE OFFSET & ADD pullHeight EventListener
var pullOnHandler = function(e) {
  pullToggle = true;
  pull.style.transition = 'none';
  document.addEventListener('touchmove',function foo(e) {
    pullHeight(e,pullToggle);
  });
  cursorClickOffset = mobile ? wOuterH-(e.targetTouches[0].pageY) : wOuterH-(e.clientY);
};

// INPUT RELEASE
var pullOffHandler = function(e) {
  pullToggle = false;
  document.removeEventListener('touchmove', function(e) {
    pullHeight(e,pullToggle);
  });
  
  pull.style.transition = 'transform 0.25s ease-in';
  pull.style.transform = 'translateY(0)';
  
  if (pullSuccess) {
    pull.style.transform = 'translateY(-47px)';
    cursorClickOffset = 0;
    
    // PUT STATE CHANGE FUNCTION HERE TO TRIGGER ON RELEASE
    
  }
};

function pullHeight(inp,trueFalse) {
  if (trueFalse) {
    // CALC FROM DOC HEIGHT, INITIAL CLICK POS, & CLICK MOVE
    var pullHeightZeroed = mobile ? (window.outerHeight-inp.targetTouches[0].pageY)-cursorClickOffset
      :
      (window.outerHeight-inp.clientY)-cursorClickOffset;
    // LIMIT DRAG DISTANCE, & TRANSLATE BY HALF
    if (pullHeightZeroed/2 < maxH) {
      var algPull = pullHeightZeroed/(maxH*2);
      if (algPull < 0.3) { algPull = 0.3; }
      overpull.style.opacity = algPull;
      overpull.style.transform = 'translateY(-' + (pullHeightZeroed/2) + 'px)';
    }
    // TRIGGER W/ A LITTLE EXTRA ROOM TO SPARE
    if ((pullHeightZeroed*2/3) > maxH) {
      msg.classList.add('show');
      pullSuccess = true;
      
      // PUT STATE CHANGE FUNCTION HERE FOR IMMEDIATE
      setTimeout(function() {
        dragNext();
      },500);

    }
  }
}

// FIND NEXT PAGE NUMBER
var nextPage = paramP == pagesNo ? 1 : Number(paramP)+1; 

var dragNext = function dragNext() {
  window.location = 'https://thaliamae.com?p=' + nextPage;
}