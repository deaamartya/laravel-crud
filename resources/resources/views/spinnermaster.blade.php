<head>
<style type="text/css">
	.ctrl {
  -webkit-box-flex: 0;
  -webkit-flex: 0 0 auto;
  -ms-flex: 0 0 auto;
  flex: 0 0 auto;
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: center;
  -webkit-align-items: center;
  -ms-flex-align: center;
  align-items: center;
  border-bottom: 1px solid #D5DCE6;
  background-color: #fff;
  border-radius: 5px;
  font-size: 30px;
}

.ctrl__counter {
  position: relative;
  width: 200px;
  height: 100px;
  color: #333C48;
  text-align: center;
  overflow: hidden;
}

.ctrl__counter.is-input .ctrl__counter-num {
  visability: hidden;
  opacity: 0;
  -webkit-transition: opacity 100ms ease-in;
  transition: opacity 100ms ease-in;
}

.ctrl__counter.is-input .ctrl__counter-input {
  visability: visible;
  opacity: 1;
  -webkit-transition: opacity 100ms ease-in;
  transition: opacity 100ms ease-in;
}

.ctrl__counter-input {
  width: 100%;
  margin: 0;
  padding: 0;
  position: relative;
  z-index: 2;
  box-shadow: none;
  outline: none;
  border: none;
  color: #333C48;
  font-size: 30px;
  line-height: 100px;
  text-align: center;
  visability: hidden;
  opacity: 0;
  -webkit-transition: opacity 100ms ease-in;
  transition: opacity 100ms ease-in;
}

.ctrl__button {
  width: 100px;
  line-height: 100px;
  text-align: center;
  color: #fff;
  cursor: pointer;
  background-color: #8498a7;
  -webkit-transition: background-color 100ms ease-in;
  transition: background-color 100ms ease-in;
}

.ctrl__button:hover {
  background-color: #90a2b0;
  -webkit-transition: background-color 100ms ease-in;
  transition: background-color 100ms ease-in;
}

.ctrl__button:active {
  background-color: #778996;
  -webkit-transition: background-color 100ms ease-in;
  transition: background-color 100ms ease-in;
}

.ctrl__button--decrement { border-radius: 5px 0 0 5px; }

.ctrl__button--increment { border-radius: 0 5px 5px 0; }

.ctrl__counter-num {
  position: absolute;
  z-index: 1;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  line-height: 100px;
  visability: visible;
  opacity: 1;
  -webkit-transition: opacity 100ms ease-in;
  transition: opacity 100ms ease-in;
}

.ctrl__counter-num.is-increment-hide {
  opacity: 0;
  -webkit-transform: translateY(-50px);
  transform: translateY(-50px);
  -webkit-animation: increment-prev 100ms ease-in;
  animation: increment-prev 100ms ease-in;
}

.ctrl__counter-num.is-increment-visible {
  opacity: 1;
  -webkit-transform: translateY(0);
  transform: translateY(0);
  -webkit-animation: increment-next 100ms ease-out;
  animation: increment-next 100ms ease-out;
}

.ctrl__counter-num.is-decrement-hide {
  opacity: 0;
  -webkit-transform: translateY(50px);
  transform: translateY(50px);
  -webkit-animation: decrement-prev 100ms ease-in;
  animation: decrement-prev 100ms ease-in;
}

.ctrl__counter-num.is-decrement-visible {
  opacity: 1;
  -webkit-transform: translateY(0);
  transform: translateY(0);
  -webkit-animation: decrement-next 100ms ease-out;
  animation: decrement-next 100ms ease-out;
}

@-webkit-keyframes 
decrement-prev {  from {
 opacity: 1;
 -webkit-transform: translateY(0);
 transform: translateY(0);
}
}

@keyframes 
decrement-prev {  from {
 opacity: 1;
 -webkit-transform: translateY(0);
 transform: translateY(0);
}
}

@-webkit-keyframes 
decrement-next {  from {
 opacity: 0;
 -webkit-transform: translateY(-50px);
 transform: translateY(-50px);
}
}

@keyframes 
decrement-next {  from {
 opacity: 0;
 -webkit-transform: translateY(-50px);
 transform: translateY(-50px);
}
}

@-webkit-keyframes 
increment-prev {  from {
 opacity: 1;
 -webkit-transform: translateY(0);
 transform: translateY(0);
}
}

@keyframes 
increment-prev {  from {
 opacity: 1;
 -webkit-transform: translateY(0);
 transform: translateY(0);
}
}

@-webkit-keyframes 
increment-next {  from {
 opacity: 0;
 -webkit-transform: translateY(50px);
 transform: translateY(50px);
}
}

@keyframes 
increment-next {  from {
 opacity: 0;
 -webkit-transform: translateY(50px);
 transform: translateY(50px);
}
}
</style>
</head>

<body>
  <input type="number" id="jumlah" hidden value="{{$id}}">
</body>

<script type="text/javascript">
  (function() {
  'use strict';

  function ctrls() {
    var stock = document.getElementById("jumlah{{$id}}").max; 
    var _this = this;

    this.counter = 0;
    this.els = {
      decrement: document.querySelector('.ctrl__button--decrement'),
      counter: {
        container: document.querySelector('.ctrl__counter'),
        num: document.querySelector('.ctrl__counter-num'),
        input: document.querySelector('.ctrl__counter-input')
      },
      increment: document.querySelector('.ctrl__button--increment')
    };

    this.decrement = function() {
      var counter = _this.getCounter();
      var nextCounter = (_this.counter > 0) ? --counter : counter;
      _this.setCounter(nextCounter);
    };

    this.increment = function() {
      var counter = _this.getCounter();
      var nextCounter = (counter < stock) ? ++counter : counter;
      _this.setCounter(nextCounter);
    };

    this.getCounter = function() {
      return _this.counter;
    };

    this.setCounter = function(nextCounter) {
      _this.counter = nextCounter;
    };

    this.debounce = function(callback) {
      setTimeout(callback, 100);
    };

    this.render = function(hideClassName, visibleClassName) {
      _this.els.counter.num.classList.add(hideClassName);

      setTimeout(function() {
        _this.els.counter.num.innerText = _this.getCounter();
        _this.els.counter.input.value = _this.getCounter();
        _this.els.counter.num.classList.add(visibleClassName);
      }, 100);

      setTimeout(function() {
        _this.els.counter.num.classList.remove(hideClassName);
        _this.els.counter.num.classList.remove(visibleClassName);
      }, 200);
    };

    this.ready = function() {
      _this.els.decrement.addEventListener('click', function() {
        _this.debounce(function() {
          _this.decrement();
          _this.render('is-decrement-hide', 'is-decrement-visible');
          myFunction(id);
        });
      });

      _this.els.increment.addEventListener('click', function() {
        _this.debounce(function() {
          _this.increment();
          _this.render('is-increment-hide', 'is-increment-visible');
          myFunction(id);
        });
      });

      _this.els.counter.input.addEventListener('input', function(e) {
        var parseValue = parseInt(e.target.value);
        if (!isNaN(parseValue) && parseValue >= 0) {
          _this.setCounter(parseValue);
          _this.render();
        }
        myFunction(id);
      });

      _this.els.counter.input.addEventListener('focus', function(e) {
        _this.els.counter.container.classList.add('is-input');
        myFunction(id);
      });

      _this.els.counter.input.addEventListener('blur', function(e) {
        _this.els.counter.container.classList.remove('is-input');
        _this.render();
        myFunction(id);
      });
    };
  };

  // init
  var controls = new ctrls();
  document.addEventListener('DOMContentLoaded', controls.ready);
})();
</script>
