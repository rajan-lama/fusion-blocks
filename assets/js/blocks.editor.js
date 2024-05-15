/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 49);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports) {

var core = module.exports = { version: '2.6.5' };
if (typeof __e == 'number') __e = core; // eslint-disable-line no-undef


/***/ }),
/* 1 */
/***/ (function(module, exports) {

// https://github.com/zloirock/core-js/issues/86#issuecomment-115759028
var global = module.exports = typeof window != 'undefined' && window.Math == Math
  ? window : typeof self != 'undefined' && self.Math == Math ? self
  // eslint-disable-next-line no-new-func
  : Function('return this')();
if (typeof __g == 'number') __g = global; // eslint-disable-line no-undef


/***/ }),
/* 2 */
/***/ (function(module, exports) {

var hasOwnProperty = {}.hasOwnProperty;
module.exports = function (it, key) {
  return hasOwnProperty.call(it, key);
};


/***/ }),
/* 3 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(1);
var core = __webpack_require__(0);
var ctx = __webpack_require__(40);
var hide = __webpack_require__(7);
var has = __webpack_require__(2);
var PROTOTYPE = 'prototype';

var $export = function (type, name, source) {
  var IS_FORCED = type & $export.F;
  var IS_GLOBAL = type & $export.G;
  var IS_STATIC = type & $export.S;
  var IS_PROTO = type & $export.P;
  var IS_BIND = type & $export.B;
  var IS_WRAP = type & $export.W;
  var exports = IS_GLOBAL ? core : core[name] || (core[name] = {});
  var expProto = exports[PROTOTYPE];
  var target = IS_GLOBAL ? global : IS_STATIC ? global[name] : (global[name] || {})[PROTOTYPE];
  var key, own, out;
  if (IS_GLOBAL) source = name;
  for (key in source) {
    // contains in native
    own = !IS_FORCED && target && target[key] !== undefined;
    if (own && has(exports, key)) continue;
    // export native or passed
    out = own ? target[key] : source[key];
    // prevent global pollution for namespaces
    exports[key] = IS_GLOBAL && typeof target[key] != 'function' ? source[key]
    // bind timers to global for call from export context
    : IS_BIND && own ? ctx(out, global)
    // wrap global constructors for prevent change them in library
    : IS_WRAP && target[key] == out ? (function (C) {
      var F = function (a, b, c) {
        if (this instanceof C) {
          switch (arguments.length) {
            case 0: return new C();
            case 1: return new C(a);
            case 2: return new C(a, b);
          } return new C(a, b, c);
        } return C.apply(this, arguments);
      };
      F[PROTOTYPE] = C[PROTOTYPE];
      return F;
    // make static versions for prototype methods
    })(out) : IS_PROTO && typeof out == 'function' ? ctx(Function.call, out) : out;
    // export proto methods to core.%CONSTRUCTOR%.methods.%NAME%
    if (IS_PROTO) {
      (exports.virtual || (exports.virtual = {}))[key] = out;
      // export proto methods to core.%CONSTRUCTOR%.prototype.%NAME%
      if (type & $export.R && expProto && !expProto[key]) hide(expProto, key, out);
    }
  }
};
// type bitmap
$export.F = 1;   // forced
$export.G = 2;   // global
$export.S = 4;   // static
$export.P = 8;   // proto
$export.B = 16;  // bind
$export.W = 32;  // wrap
$export.U = 64;  // safe
$export.R = 128; // real proto method for `library`
module.exports = $export;


/***/ }),
/* 4 */
/***/ (function(module, exports, __webpack_require__) {

var anObject = __webpack_require__(12);
var IE8_DOM_DEFINE = __webpack_require__(41);
var toPrimitive = __webpack_require__(28);
var dP = Object.defineProperty;

exports.f = __webpack_require__(5) ? Object.defineProperty : function defineProperty(O, P, Attributes) {
  anObject(O);
  P = toPrimitive(P, true);
  anObject(Attributes);
  if (IE8_DOM_DEFINE) try {
    return dP(O, P, Attributes);
  } catch (e) { /* empty */ }
  if ('get' in Attributes || 'set' in Attributes) throw TypeError('Accessors not supported!');
  if ('value' in Attributes) O[P] = Attributes.value;
  return O;
};


/***/ }),
/* 5 */
/***/ (function(module, exports, __webpack_require__) {

// Thank's IE8 for his funny defineProperty
module.exports = !__webpack_require__(9)(function () {
  return Object.defineProperty({}, 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 6 */
/***/ (function(module, exports, __webpack_require__) {

// to indexed object, toObject with fallback for non-array-like ES3 strings
var IObject = __webpack_require__(37);
var defined = __webpack_require__(23);
module.exports = function (it) {
  return IObject(defined(it));
};


/***/ }),
/* 7 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(4);
var createDesc = __webpack_require__(16);
module.exports = __webpack_require__(5) ? function (object, key, value) {
  return dP.f(object, key, createDesc(1, value));
} : function (object, key, value) {
  object[key] = value;
  return object;
};


/***/ }),
/* 8 */
/***/ (function(module, exports) {

module.exports = function (it) {
  return typeof it === 'object' ? it !== null : typeof it === 'function';
};


/***/ }),
/* 9 */
/***/ (function(module, exports) {

module.exports = function (exec) {
  try {
    return !!exec();
  } catch (e) {
    return true;
  }
};


/***/ }),
/* 10 */
/***/ (function(module, exports, __webpack_require__) {

var store = __webpack_require__(26)('wks');
var uid = __webpack_require__(15);
var Symbol = __webpack_require__(1).Symbol;
var USE_SYMBOL = typeof Symbol == 'function';

var $exports = module.exports = function (name) {
  return store[name] || (store[name] =
    USE_SYMBOL && Symbol[name] || (USE_SYMBOL ? Symbol : uid)('Symbol.' + name));
};

$exports.store = store;


/***/ }),
/* 11 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 / 15.2.3.14 Object.keys(O)
var $keys = __webpack_require__(36);
var enumBugKeys = __webpack_require__(27);

module.exports = Object.keys || function keys(O) {
  return $keys(O, enumBugKeys);
};


/***/ }),
/* 12 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(8);
module.exports = function (it) {
  if (!isObject(it)) throw TypeError(it + ' is not an object!');
  return it;
};


/***/ }),
/* 13 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.13 ToObject(argument)
var defined = __webpack_require__(23);
module.exports = function (it) {
  return Object(defined(it));
};


/***/ }),
/* 14 */
/***/ (function(module, exports) {

module.exports = true;


/***/ }),
/* 15 */
/***/ (function(module, exports) {

var id = 0;
var px = Math.random();
module.exports = function (key) {
  return 'Symbol('.concat(key === undefined ? '' : key, ')_', (++id + px).toString(36));
};


/***/ }),
/* 16 */
/***/ (function(module, exports) {

module.exports = function (bitmap, value) {
  return {
    enumerable: !(bitmap & 1),
    configurable: !(bitmap & 2),
    writable: !(bitmap & 4),
    value: value
  };
};


/***/ }),
/* 17 */
/***/ (function(module, exports) {

exports.f = {}.propertyIsEnumerable;


/***/ }),
/* 18 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(79), __esModule: true };

/***/ }),
/* 19 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

exports.default = function (instance, Constructor) {
  if (!(instance instanceof Constructor)) {
    throw new TypeError("Cannot call a class as a function");
  }
};

/***/ }),
/* 20 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _defineProperty = __webpack_require__(81);

var _defineProperty2 = _interopRequireDefault(_defineProperty);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = function () {
  function defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      (0, _defineProperty2.default)(target, descriptor.key, descriptor);
    }
  }

  return function (Constructor, protoProps, staticProps) {
    if (protoProps) defineProperties(Constructor.prototype, protoProps);
    if (staticProps) defineProperties(Constructor, staticProps);
    return Constructor;
  };
}();

/***/ }),
/* 21 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _typeof2 = __webpack_require__(29);

var _typeof3 = _interopRequireDefault(_typeof2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = function (self, call) {
  if (!self) {
    throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  }

  return call && ((typeof call === "undefined" ? "undefined" : (0, _typeof3.default)(call)) === "object" || typeof call === "function") ? call : self;
};

/***/ }),
/* 22 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _setPrototypeOf = __webpack_require__(84);

var _setPrototypeOf2 = _interopRequireDefault(_setPrototypeOf);

var _create = __webpack_require__(88);

var _create2 = _interopRequireDefault(_create);

var _typeof2 = __webpack_require__(29);

var _typeof3 = _interopRequireDefault(_typeof2);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = function (subClass, superClass) {
  if (typeof superClass !== "function" && superClass !== null) {
    throw new TypeError("Super expression must either be null or a function, not " + (typeof superClass === "undefined" ? "undefined" : (0, _typeof3.default)(superClass)));
  }

  subClass.prototype = (0, _create2.default)(superClass && superClass.prototype, {
    constructor: {
      value: subClass,
      enumerable: false,
      writable: true,
      configurable: true
    }
  });
  if (superClass) _setPrototypeOf2.default ? (0, _setPrototypeOf2.default)(subClass, superClass) : subClass.__proto__ = superClass;
};

/***/ }),
/* 23 */
/***/ (function(module, exports) {

// 7.2.1 RequireObjectCoercible(argument)
module.exports = function (it) {
  if (it == undefined) throw TypeError("Can't call method on  " + it);
  return it;
};


/***/ }),
/* 24 */
/***/ (function(module, exports) {

// 7.1.4 ToInteger
var ceil = Math.ceil;
var floor = Math.floor;
module.exports = function (it) {
  return isNaN(it = +it) ? 0 : (it > 0 ? floor : ceil)(it);
};


/***/ }),
/* 25 */
/***/ (function(module, exports, __webpack_require__) {

var shared = __webpack_require__(26)('keys');
var uid = __webpack_require__(15);
module.exports = function (key) {
  return shared[key] || (shared[key] = uid(key));
};


/***/ }),
/* 26 */
/***/ (function(module, exports, __webpack_require__) {

var core = __webpack_require__(0);
var global = __webpack_require__(1);
var SHARED = '__core-js_shared__';
var store = global[SHARED] || (global[SHARED] = {});

(module.exports = function (key, value) {
  return store[key] || (store[key] = value !== undefined ? value : {});
})('versions', []).push({
  version: core.version,
  mode: __webpack_require__(14) ? 'pure' : 'global',
  copyright: '© 2019 Denis Pushkarev (zloirock.ru)'
});


/***/ }),
/* 27 */
/***/ (function(module, exports) {

// IE 8- don't enum bug keys
module.exports = (
  'constructor,hasOwnProperty,isPrototypeOf,propertyIsEnumerable,toLocaleString,toString,valueOf'
).split(',');


/***/ }),
/* 28 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.1 ToPrimitive(input [, PreferredType])
var isObject = __webpack_require__(8);
// instead of the ES6 spec version, we didn't implement @@toPrimitive case
// and the second argument - flag - preferred type is a string
module.exports = function (it, S) {
  if (!isObject(it)) return it;
  var fn, val;
  if (S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  if (typeof (fn = it.valueOf) == 'function' && !isObject(val = fn.call(it))) return val;
  if (!S && typeof (fn = it.toString) == 'function' && !isObject(val = fn.call(it))) return val;
  throw TypeError("Can't convert object to primitive value");
};


/***/ }),
/* 29 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _iterator = __webpack_require__(58);

var _iterator2 = _interopRequireDefault(_iterator);

var _symbol = __webpack_require__(69);

var _symbol2 = _interopRequireDefault(_symbol);

var _typeof = typeof _symbol2.default === "function" && typeof _iterator2.default === "symbol" ? function (obj) { return typeof obj; } : function (obj) { return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj; };

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = typeof _symbol2.default === "function" && _typeof(_iterator2.default) === "symbol" ? function (obj) {
  return typeof obj === "undefined" ? "undefined" : _typeof(obj);
} : function (obj) {
  return obj && typeof _symbol2.default === "function" && obj.constructor === _symbol2.default && obj !== _symbol2.default.prototype ? "symbol" : typeof obj === "undefined" ? "undefined" : _typeof(obj);
};

/***/ }),
/* 30 */
/***/ (function(module, exports) {

module.exports = {};


/***/ }),
/* 31 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
var anObject = __webpack_require__(12);
var dPs = __webpack_require__(63);
var enumBugKeys = __webpack_require__(27);
var IE_PROTO = __webpack_require__(25)('IE_PROTO');
var Empty = function () { /* empty */ };
var PROTOTYPE = 'prototype';

// Create object with fake `null` prototype: use iframe Object with cleared prototype
var createDict = function () {
  // Thrash, waste and sodomy: IE GC bug
  var iframe = __webpack_require__(42)('iframe');
  var i = enumBugKeys.length;
  var lt = '<';
  var gt = '>';
  var iframeDocument;
  iframe.style.display = 'none';
  __webpack_require__(64).appendChild(iframe);
  iframe.src = 'javascript:'; // eslint-disable-line no-script-url
  // createDict = iframe.contentWindow.Object;
  // html.removeChild(iframe);
  iframeDocument = iframe.contentWindow.document;
  iframeDocument.open();
  iframeDocument.write(lt + 'script' + gt + 'document.F=Object' + lt + '/script' + gt);
  iframeDocument.close();
  createDict = iframeDocument.F;
  while (i--) delete createDict[PROTOTYPE][enumBugKeys[i]];
  return createDict();
};

module.exports = Object.create || function create(O, Properties) {
  var result;
  if (O !== null) {
    Empty[PROTOTYPE] = anObject(O);
    result = new Empty();
    Empty[PROTOTYPE] = null;
    // add "__proto__" for Object.getPrototypeOf polyfill
    result[IE_PROTO] = O;
  } else result = createDict();
  return Properties === undefined ? result : dPs(result, Properties);
};


/***/ }),
/* 32 */
/***/ (function(module, exports, __webpack_require__) {

var def = __webpack_require__(4).f;
var has = __webpack_require__(2);
var TAG = __webpack_require__(10)('toStringTag');

module.exports = function (it, tag, stat) {
  if (it && !has(it = stat ? it : it.prototype, TAG)) def(it, TAG, { configurable: true, value: tag });
};


/***/ }),
/* 33 */
/***/ (function(module, exports, __webpack_require__) {

exports.f = __webpack_require__(10);


/***/ }),
/* 34 */
/***/ (function(module, exports, __webpack_require__) {

var global = __webpack_require__(1);
var core = __webpack_require__(0);
var LIBRARY = __webpack_require__(14);
var wksExt = __webpack_require__(33);
var defineProperty = __webpack_require__(4).f;
module.exports = function (name) {
  var $Symbol = core.Symbol || (core.Symbol = LIBRARY ? {} : global.Symbol || {});
  if (name.charAt(0) != '_' && !(name in $Symbol)) defineProperty($Symbol, name, { value: wksExt.f(name) });
};


/***/ }),
/* 35 */
/***/ (function(module, exports) {

exports.f = Object.getOwnPropertySymbols;


/***/ }),
/* 36 */
/***/ (function(module, exports, __webpack_require__) {

var has = __webpack_require__(2);
var toIObject = __webpack_require__(6);
var arrayIndexOf = __webpack_require__(54)(false);
var IE_PROTO = __webpack_require__(25)('IE_PROTO');

module.exports = function (object, names) {
  var O = toIObject(object);
  var i = 0;
  var result = [];
  var key;
  for (key in O) if (key != IE_PROTO) has(O, key) && result.push(key);
  // Don't enum bug & hidden keys
  while (names.length > i) if (has(O, key = names[i++])) {
    ~arrayIndexOf(result, key) || result.push(key);
  }
  return result;
};


/***/ }),
/* 37 */
/***/ (function(module, exports, __webpack_require__) {

// fallback for non-array-like ES3 and non-enumerable old V8 strings
var cof = __webpack_require__(38);
// eslint-disable-next-line no-prototype-builtins
module.exports = Object('z').propertyIsEnumerable(0) ? Object : function (it) {
  return cof(it) == 'String' ? it.split('') : Object(it);
};


/***/ }),
/* 38 */
/***/ (function(module, exports) {

var toString = {}.toString;

module.exports = function (it) {
  return toString.call(it).slice(8, -1);
};


/***/ }),
/* 39 */
/***/ (function(module, exports, __webpack_require__) {

// most Object methods by ES6 should accept primitives
var $export = __webpack_require__(3);
var core = __webpack_require__(0);
var fails = __webpack_require__(9);
module.exports = function (KEY, exec) {
  var fn = (core.Object || {})[KEY] || Object[KEY];
  var exp = {};
  exp[KEY] = exec(fn);
  $export($export.S + $export.F * fails(function () { fn(1); }), 'Object', exp);
};


/***/ }),
/* 40 */
/***/ (function(module, exports, __webpack_require__) {

// optional / simple context binding
var aFunction = __webpack_require__(57);
module.exports = function (fn, that, length) {
  aFunction(fn);
  if (that === undefined) return fn;
  switch (length) {
    case 1: return function (a) {
      return fn.call(that, a);
    };
    case 2: return function (a, b) {
      return fn.call(that, a, b);
    };
    case 3: return function (a, b, c) {
      return fn.call(that, a, b, c);
    };
  }
  return function (/* ...args */) {
    return fn.apply(that, arguments);
  };
};


/***/ }),
/* 41 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = !__webpack_require__(5) && !__webpack_require__(9)(function () {
  return Object.defineProperty(__webpack_require__(42)('div'), 'a', { get: function () { return 7; } }).a != 7;
});


/***/ }),
/* 42 */
/***/ (function(module, exports, __webpack_require__) {

var isObject = __webpack_require__(8);
var document = __webpack_require__(1).document;
// typeof document.createElement is 'object' in old IE
var is = isObject(document) && isObject(document.createElement);
module.exports = function (it) {
  return is ? document.createElement(it) : {};
};


/***/ }),
/* 43 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var LIBRARY = __webpack_require__(14);
var $export = __webpack_require__(3);
var redefine = __webpack_require__(44);
var hide = __webpack_require__(7);
var Iterators = __webpack_require__(30);
var $iterCreate = __webpack_require__(62);
var setToStringTag = __webpack_require__(32);
var getPrototypeOf = __webpack_require__(45);
var ITERATOR = __webpack_require__(10)('iterator');
var BUGGY = !([].keys && 'next' in [].keys()); // Safari has buggy iterators w/o `next`
var FF_ITERATOR = '@@iterator';
var KEYS = 'keys';
var VALUES = 'values';

var returnThis = function () { return this; };

module.exports = function (Base, NAME, Constructor, next, DEFAULT, IS_SET, FORCED) {
  $iterCreate(Constructor, NAME, next);
  var getMethod = function (kind) {
    if (!BUGGY && kind in proto) return proto[kind];
    switch (kind) {
      case KEYS: return function keys() { return new Constructor(this, kind); };
      case VALUES: return function values() { return new Constructor(this, kind); };
    } return function entries() { return new Constructor(this, kind); };
  };
  var TAG = NAME + ' Iterator';
  var DEF_VALUES = DEFAULT == VALUES;
  var VALUES_BUG = false;
  var proto = Base.prototype;
  var $native = proto[ITERATOR] || proto[FF_ITERATOR] || DEFAULT && proto[DEFAULT];
  var $default = $native || getMethod(DEFAULT);
  var $entries = DEFAULT ? !DEF_VALUES ? $default : getMethod('entries') : undefined;
  var $anyNative = NAME == 'Array' ? proto.entries || $native : $native;
  var methods, key, IteratorPrototype;
  // Fix native
  if ($anyNative) {
    IteratorPrototype = getPrototypeOf($anyNative.call(new Base()));
    if (IteratorPrototype !== Object.prototype && IteratorPrototype.next) {
      // Set @@toStringTag to native iterators
      setToStringTag(IteratorPrototype, TAG, true);
      // fix for some old engines
      if (!LIBRARY && typeof IteratorPrototype[ITERATOR] != 'function') hide(IteratorPrototype, ITERATOR, returnThis);
    }
  }
  // fix Array#{values, @@iterator}.name in V8 / FF
  if (DEF_VALUES && $native && $native.name !== VALUES) {
    VALUES_BUG = true;
    $default = function values() { return $native.call(this); };
  }
  // Define iterator
  if ((!LIBRARY || FORCED) && (BUGGY || VALUES_BUG || !proto[ITERATOR])) {
    hide(proto, ITERATOR, $default);
  }
  // Plug for library
  Iterators[NAME] = $default;
  Iterators[TAG] = returnThis;
  if (DEFAULT) {
    methods = {
      values: DEF_VALUES ? $default : getMethod(VALUES),
      keys: IS_SET ? $default : getMethod(KEYS),
      entries: $entries
    };
    if (FORCED) for (key in methods) {
      if (!(key in proto)) redefine(proto, key, methods[key]);
    } else $export($export.P + $export.F * (BUGGY || VALUES_BUG), NAME, methods);
  }
  return methods;
};


/***/ }),
/* 44 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(7);


/***/ }),
/* 45 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.9 / 15.2.3.2 Object.getPrototypeOf(O)
var has = __webpack_require__(2);
var toObject = __webpack_require__(13);
var IE_PROTO = __webpack_require__(25)('IE_PROTO');
var ObjectProto = Object.prototype;

module.exports = Object.getPrototypeOf || function (O) {
  O = toObject(O);
  if (has(O, IE_PROTO)) return O[IE_PROTO];
  if (typeof O.constructor == 'function' && O instanceof O.constructor) {
    return O.constructor.prototype;
  } return O instanceof Object ? ObjectProto : null;
};


/***/ }),
/* 46 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.7 / 15.2.3.4 Object.getOwnPropertyNames(O)
var $keys = __webpack_require__(36);
var hiddenKeys = __webpack_require__(27).concat('length', 'prototype');

exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
  return $keys(O, hiddenKeys);
};


/***/ }),
/* 47 */
/***/ (function(module, exports, __webpack_require__) {

var pIE = __webpack_require__(17);
var createDesc = __webpack_require__(16);
var toIObject = __webpack_require__(6);
var toPrimitive = __webpack_require__(28);
var has = __webpack_require__(2);
var IE8_DOM_DEFINE = __webpack_require__(41);
var gOPD = Object.getOwnPropertyDescriptor;

exports.f = __webpack_require__(5) ? gOPD : function getOwnPropertyDescriptor(O, P) {
  O = toIObject(O);
  P = toPrimitive(P, true);
  if (IE8_DOM_DEFINE) try {
    return gOPD(O, P);
  } catch (e) { /* empty */ }
  if (has(O, P)) return createDesc(!pIE.f.call(O, P), O[P]);
};


/***/ }),
/* 48 */
/***/ (function(module, exports, __webpack_require__) {

var __WEBPACK_AMD_DEFINE_ARRAY__, __WEBPACK_AMD_DEFINE_RESULT__;/*!
  Copyright (c) 2017 Jed Watson.
  Licensed under the MIT License (MIT), see
  http://jedwatson.github.io/classnames
*/
/* global define */

(function () {
	'use strict';

	var hasOwn = {}.hasOwnProperty;

	function classNames () {
		var classes = [];

		for (var i = 0; i < arguments.length; i++) {
			var arg = arguments[i];
			if (!arg) continue;

			var argType = typeof arg;

			if (argType === 'string' || argType === 'number') {
				classes.push(arg);
			} else if (Array.isArray(arg) && arg.length) {
				var inner = classNames.apply(null, arg);
				if (inner) {
					classes.push(inner);
				}
			} else if (argType === 'object') {
				for (var key in arg) {
					if (hasOwn.call(arg, key) && arg[key]) {
						classes.push(key);
					}
				}
			}
		}

		return classes.join(' ');
	}

	if (typeof module !== 'undefined' && module.exports) {
		classNames.default = classNames;
		module.exports = classNames;
	} else if (true) {
		// register as 'classnames', consistent with npm package name
		!(__WEBPACK_AMD_DEFINE_ARRAY__ = [], __WEBPACK_AMD_DEFINE_RESULT__ = (function () {
			return classNames;
		}).apply(exports, __WEBPACK_AMD_DEFINE_ARRAY__),
				__WEBPACK_AMD_DEFINE_RESULT__ !== undefined && (module.exports = __WEBPACK_AMD_DEFINE_RESULT__));
	} else {
		window.classNames = classNames;
	}
}());


/***/ }),
/* 49 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__ps_accordian___ = __webpack_require__(50);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__ps_block_blog_item___ = __webpack_require__(91);




/***/ }),
/* 50 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys__ = __webpack_require__(51);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_typeof__ = __webpack_require__(29);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_typeof___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_typeof__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_core_js_object_get_prototype_of__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_core_js_object_get_prototype_of___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_babel_runtime_core_js_object_get_prototype_of__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_classCallCheck__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_classCallCheck___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_classCallCheck__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_createClass__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_createClass___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_createClass__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_possibleConstructorReturn__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_possibleConstructorReturn___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_possibleConstructorReturn__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_babel_runtime_helpers_inherits__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_babel_runtime_helpers_inherits___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_babel_runtime_helpers_inherits__);







(function (wpI18n, wpBlocks, wpElement, wpBlockEditor, wpComponents) {
    wpBlockEditor = wp.blockEditor || wp.editor;
    var __ = wpI18n.__;
    var Component = wpElement.Component,
        Fragment = wpElement.Fragment;
    var registerBlockType = wpBlocks.registerBlockType,
        createBlock = wpBlocks.createBlock;
    var _wpBlockEditor = wpBlockEditor,
        InspectorControls = _wpBlockEditor.InspectorControls,
        RichText = _wpBlockEditor.RichText,
        PanelColorSettings = _wpBlockEditor.PanelColorSettings,
        InnerBlocks = _wpBlockEditor.InnerBlocks;
    var RangeControl = wpComponents.RangeControl,
        PanelBody = wpComponents.PanelBody,
        BaseControl = wpComponents.BaseControl,
        SelectControl = wpComponents.SelectControl,
        ToggleControl = wpComponents.ToggleControl;


    var HEADER_ICONS = {
        plus: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M19,13h-6v6h-2v-6H5v-2h6V5h2v6h6V13z" })
        ),
        plusCircle: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M17,13h-4v4h-2v-4H7v-2h4V7h2v4h4V13z" })
        ),
        plusCircleOutline: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M13,7h-2v4H7v2h4v4h2v-4h4v-2h-4V7z M12,2C6.48,2,2,6.48,2,12s4.48,10,10,10s10-4.48,10-10S17.52,2,12,2z M12,20 c-4.41,0-8-3.59-8-8s3.59-8,8-8s8,3.59,8,8S16.41,20,12,20z" })
        ),
        plusBox: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M19,3H5C3.89,3,3,3.9,3,5v14c0,1.1,0.89,2,2,2h14c1.1,0,2-0.9,2-2V5C21,3.9,20.1,3,19,3z M19,19H5V5h14V19z" }),
            React.createElement("polygon", { points: "11,17 13,17 13,13 17,13 17,11 13,11 13,7 11,7 11,11 7,11 7,13 11,13" })
        ),
        unfold: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M12,5.83L15.17,9l1.41-1.41L12,3L7.41,7.59L8.83,9L12,5.83z M12,18.17L8.83,15l-1.41,1.41L12,21l4.59-4.59L15.17,15 L12,18.17z" })
        ),
        threeDots: React.createElement(
            Fragment,
            null,
            React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
            React.createElement("path", { d: "M6,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S7.1,10,6,10z M18,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S19.1,10,18,10z M12,10c-1.1,0-2,0.9-2,2s0.9,2,2,2s2-0.9,2-2S13.1,10,12,10z" })
        ),
        arrowDown: React.createElement(
            Fragment,
            null,
            React.createElement("path", { opacity: "0.87", fill: "none", d: "M24,24H0L0,0l24,0V24z" }),
            React.createElement("path", { d: "M16.59,8.59L12,13.17L7.41,8.59L6,10l6,6l6-6L16.59,8.59z" })
        )
    };

    var AdvAccordion = function (_Component) {
        __WEBPACK_IMPORTED_MODULE_6_babel_runtime_helpers_inherits___default()(AdvAccordion, _Component);

        function AdvAccordion() {
            __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_classCallCheck___default()(this, AdvAccordion);

            var _this = __WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_possibleConstructorReturn___default()(this, (AdvAccordion.__proto__ || __WEBPACK_IMPORTED_MODULE_2_babel_runtime_core_js_object_get_prototype_of___default()(AdvAccordion)).apply(this, arguments));

            _this.state = {
                currentAccordion: null
            };
            return _this;
        }

        __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_createClass___default()(AdvAccordion, [{
            key: "componentWillMount",
            value: function componentWillMount() {
                var _props = this.props,
                    attributes = _props.attributes,
                    setAttributes = _props.setAttributes;

                var currentBlockConfig = advgbDefaultConfig['ppb-accordion'];

                // No override attributes of blocks inserted before
                if (attributes.changed !== true) {
                    if ((typeof currentBlockConfig === "undefined" ? "undefined" : __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_typeof___default()(currentBlockConfig)) === 'object' && currentBlockConfig !== null) {
                        __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys___default()(currentBlockConfig).map(function (attribute) {
                            if (typeof attributes[attribute] === 'boolean') {
                                attributes[attribute] = !!currentBlockConfig[attribute];
                            } else {
                                attributes[attribute] = currentBlockConfig[attribute];
                            }
                        });
                    }

                    // Finally set changed attribute to true, so we don't modify anything again
                    setAttributes({ changed: true });
                }
            }
        }, {
            key: "render",
            value: function render() {
                var _props2 = this.props,
                    attributes = _props2.attributes,
                    setAttributes = _props2.setAttributes;
                var header = attributes.header,
                    headerBgColor = attributes.headerBgColor,
                    headerTextColor = attributes.headerTextColor,
                    headerIcon = attributes.headerIcon,
                    headerIconColor = attributes.headerIconColor,
                    bodyBgColor = attributes.bodyBgColor,
                    bodyTextColor = attributes.bodyTextColor,
                    borderStyle = attributes.borderStyle,
                    borderWidth = attributes.borderWidth,
                    borderColor = attributes.borderColor,
                    borderRadius = attributes.borderRadius,
                    marginBottom = attributes.marginBottom,
                    collapsedAll = attributes.collapsedAll;


                return React.createElement(
                    Fragment,
                    null,
                    React.createElement(
                        InspectorControls,
                        null,
                        React.createElement(
                            PanelBody,
                            { title: __('Notice', 'prosys-power-block') },
                            React.createElement(
                                "p",
                                { style: { color: '#ff0000', fontStyle: 'italic' } },
                                __("This accordion block has been replaced by a new and better one.\n                                 This block will be removed in a future version.\n                                 Please transform this to an Accordion Item block\n                                 and drag them into new Adv. Accordion block as soon as possible.", 'prosys-power-block')
                            )
                        ),
                        React.createElement(
                            PanelBody,
                            { title: __('Accordion Settings', 'prosys-power-block') },
                            React.createElement(RangeControl, {
                                label: __('Bottom spacing', 'prosys-power-block'),
                                value: marginBottom,
                                help: __('Define space to next block. This will override Block spacing option (Frontend view only)', 'prosys-power-block'),
                                min: 0,
                                max: 50,
                                onChange: function onChange(value) {
                                    return setAttributes({ marginBottom: value });
                                }
                            })
                        ),
                        React.createElement(
                            PanelBody,
                            { title: __('Header Settings', 'prosys-power-block') },
                            React.createElement(
                                BaseControl,
                                { label: __('Header Icon Style', 'prosys-power-block') },
                                React.createElement(
                                    "div",
                                    { className: "advgb-icon-items-wrapper" },
                                    __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_keys___default()(HEADER_ICONS).map(function (key, index) {
                                        return React.createElement(
                                            "div",
                                            { className: "advgb-icon-item", key: index },
                                            React.createElement(
                                                "span",
                                                { className: key === headerIcon ? 'active' : '',
                                                    onClick: function onClick() {
                                                        return setAttributes({ headerIcon: key });
                                                    } },
                                                React.createElement(
                                                    "svg",
                                                    { xmlns: "http://www.w3.org/2000/svg", width: "24", height: "24", viewBox: "0 0 24 24" },
                                                    HEADER_ICONS[key]
                                                )
                                            )
                                        );
                                    })
                                )
                            ),
                            React.createElement(PanelColorSettings, {
                                title: __('Color Settings', 'prosys-power-block'),
                                initialOpen: false,
                                colorSettings: [{
                                    label: __('Background Color', 'prosys-power-block'),
                                    value: headerBgColor,
                                    onChange: function onChange(value) {
                                        return setAttributes({ headerBgColor: value === undefined ? '#000' : value });
                                    }
                                }, {
                                    label: __('Text Color', 'prosys-power-block'),
                                    value: headerTextColor,
                                    onChange: function onChange(value) {
                                        return setAttributes({ headerTextColor: value === undefined ? '#eee' : value });
                                    }
                                }, {
                                    label: __('Icon Color', 'prosys-power-block'),
                                    value: headerIconColor,
                                    onChange: function onChange(value) {
                                        return setAttributes({ headerIconColor: value === undefined ? '#fff' : value });
                                    }
                                }]
                            })
                        ),
                        React.createElement(PanelColorSettings, {
                            title: __('Body Color Settings', 'prosys-power-block'),
                            initialOpen: false,
                            colorSettings: [{
                                label: __('Background Color', 'prosys-power-block'),
                                value: bodyBgColor,
                                onChange: function onChange(value) {
                                    return setAttributes({ bodyBgColor: value });
                                }
                            }, {
                                label: __('Text Color', 'prosys-power-block'),
                                value: bodyTextColor,
                                onChange: function onChange(value) {
                                    return setAttributes({ bodyTextColor: value });
                                }
                            }]
                        }),
                        React.createElement(
                            PanelBody,
                            { title: __('Border Settings', 'prosys-power-block'), initialOpen: false },
                            React.createElement(SelectControl, {
                                label: __('Border Style', 'prosys-power-block'),
                                value: borderStyle,
                                options: [{ label: __('Solid', 'prosys-power-block'), value: 'solid' }, { label: __('Dashed', 'prosys-power-block'), value: 'dashed' }, { label: __('Dotted', 'prosys-power-block'), value: 'dotted' }],
                                onChange: function onChange(value) {
                                    return setAttributes({ borderStyle: value });
                                }
                            }),
                            React.createElement(PanelColorSettings, {
                                title: __('Color Settings', 'prosys-power-block'),
                                initialOpen: false,
                                colorSettings: [{
                                    label: __('Border Color', 'prosys-power-block'),
                                    value: borderColor,
                                    onChange: function onChange(value) {
                                        return setAttributes({ borderColor: value });
                                    }
                                }]
                            }),
                            React.createElement(RangeControl, {
                                label: __('Border width', 'prosys-power-block'),
                                value: borderWidth,
                                min: 0,
                                max: 10,
                                onChange: function onChange(value) {
                                    return setAttributes({ borderWidth: value });
                                }
                            }),
                            React.createElement(RangeControl, {
                                label: __('Border radius', 'prosys-power-block'),
                                value: borderRadius,
                                min: 0,
                                max: 100,
                                onChange: function onChange(value) {
                                    return setAttributes({ borderRadius: value });
                                }
                            })
                        ),
                        React.createElement(
                            PanelBody,
                            { title: __('Accordions State', 'prosys-power-block'), initialOpen: false },
                            React.createElement(ToggleControl, {
                                label: __('Initial Collapsed', 'prosys-power-block'),
                                help: __('Make all accordions collapsed by default, enable this setting to apply to all accordions.', 'prosys-power-block'),
                                checked: collapsedAll,
                                onChange: function onChange() {
                                    return setAttributes({ collapsedAll: !collapsedAll });
                                }
                            })
                        )
                    ),
                    React.createElement(
                        "div",
                        { className: "advgb-accordion-block" },
                        React.createElement(
                            "div",
                            { className: "advgb-accordion-header",
                                style: {
                                    backgroundColor: headerBgColor,
                                    color: headerTextColor,
                                    borderStyle: borderStyle,
                                    borderWidth: borderWidth + 'px',
                                    borderColor: borderColor,
                                    borderRadius: borderRadius + 'px'
                                }
                            },
                            React.createElement(
                                "span",
                                { className: "advgb-accordion-header-icon" },
                                React.createElement(
                                    "svg",
                                    { fill: headerIconColor, xmlns: "http://www.w3.org/2000/svg", width: "24", height: "24", viewBox: "0 0 24 24" },
                                    HEADER_ICONS[headerIcon]
                                )
                            ),
                            React.createElement(RichText, {
                                tagName: "h4",
                                value: header,
                                onChange: function onChange(value) {
                                    return setAttributes({ header: value });
                                },
                                unstableOnSplit: function unstableOnSplit() {
                                    return null;
                                },
                                className: "advgb-accordion-header-title",
                                placeholder: __('Enter header…', 'prosys-power-block')
                            })
                        ),
                        React.createElement(
                            "div",
                            { className: "advgb-accordion-body",
                                style: {
                                    backgroundColor: bodyBgColor,
                                    color: bodyTextColor,
                                    borderStyle: borderStyle,
                                    borderWidth: borderWidth + 'px',
                                    borderColor: borderColor,
                                    borderRadius: borderRadius + 'px'
                                }
                            },
                            React.createElement(InnerBlocks, null)
                        )
                    )
                );
            }
        }]);

        return AdvAccordion;
    }(Component);

    var accordionBlockIcon = React.createElement(
        "svg",
        { xmlns: "http://www.w3.org/2000/svg", width: "20", height: "20", viewBox: "2 2 22 22" },
        React.createElement("path", { fill: "none", d: "M0,0h24v24H0V0z" }),
        React.createElement("rect", { x: "3", y: "17", width: "18", height: "2" }),
        React.createElement("path", { d: "M19,12v1H5v-1H19 M21,10H3v5h18V10L21,10z" }),
        React.createElement("rect", { x: "3", y: "6", width: "18", height: "2" })
    );

    var accordionAttrs = {
        header: {
            type: 'string',
            default: __('Header text', 'prosys-power-block')
        },
        headerBgColor: {
            type: 'string',
            default: '#000'
        },
        headerTextColor: {
            type: 'string',
            default: '#eee'
        },
        headerIcon: {
            type: 'string',
            default: 'unfold'
        },
        headerIconColor: {
            type: 'string',
            default: '#fff'
        },
        bodyBgColor: {
            type: 'string'
        },
        bodyTextColor: {
            type: 'string'
        },
        borderStyle: {
            type: 'string',
            default: 'solid'
        },
        borderWidth: {
            type: 'number',
            default: 0
        },
        borderColor: {
            type: 'string'
        },
        borderRadius: {
            type: 'number',
            default: 2
        },
        marginBottom: {
            type: 'number',
            default: 15
        },
        collapsedAll: {
            type: 'boolean',
            default: false
        },
        changed: {
            type: 'boolean',
            default: false
        }
    };

    registerBlockType('prosys-power-block/accordion', {
        title: __('Accordion', 'prosys-power-block'),
        description: __('Easy to create an accordion for your post/page.', 'prosys-power-block'),
        icon: {
            src: accordionBlockIcon,
            foreground: typeof advgbBlocks !== 'undefined' ? advgbBlocks.color : undefined
        },
        category: 'ppb-category',
        keywords: [__('accordion', 'prosys-power-block'), __('list', 'prosys-power-block'), __('faq', 'prosys-power-block')],
        attributes: accordionAttrs,
        supports: {
            inserter: false
        },
        edit: AdvAccordion,
        save: function save(_ref) {
            var attributes = _ref.attributes;
            var header = attributes.header,
                headerBgColor = attributes.headerBgColor,
                headerTextColor = attributes.headerTextColor,
                headerIcon = attributes.headerIcon,
                headerIconColor = attributes.headerIconColor,
                bodyBgColor = attributes.bodyBgColor,
                bodyTextColor = attributes.bodyTextColor,
                borderStyle = attributes.borderStyle,
                borderWidth = attributes.borderWidth,
                borderColor = attributes.borderColor,
                borderRadius = attributes.borderRadius,
                marginBottom = attributes.marginBottom,
                collapsedAll = attributes.collapsedAll;


            return React.createElement(
                "div",
                { className: "advgb-accordion-block", style: { marginBottom: marginBottom }, "data-collapsed": collapsedAll ? collapsedAll : undefined },
                React.createElement(
                    "div",
                    { className: "advgb-accordion-header",
                        style: {
                            backgroundColor: headerBgColor,
                            color: headerTextColor,
                            borderStyle: borderStyle,
                            borderWidth: borderWidth + 'px',
                            borderColor: borderColor,
                            borderRadius: borderRadius + 'px'
                        }
                    },
                    React.createElement(
                        "span",
                        { className: "advgb-accordion-header-icon" },
                        React.createElement(
                            "svg",
                            { fill: headerIconColor, xmlns: "http://www.w3.org/2000/svg", width: "24", height: "24", viewBox: "0 0 24 24" },
                            HEADER_ICONS[headerIcon]
                        )
                    ),
                    React.createElement(
                        "h4",
                        { className: "advgb-accordion-header-title" },
                        header
                    )
                ),
                React.createElement(
                    "div",
                    { className: "advgb-accordion-body",
                        style: {
                            backgroundColor: bodyBgColor,
                            color: bodyTextColor,
                            borderStyle: borderStyle,
                            borderWidth: borderWidth + 'px',
                            borderColor: borderColor,
                            borderRadius: borderRadius + 'px'
                        }
                    },
                    React.createElement(InnerBlocks.Content, null)
                )
            );
        }

    });
})(wp.i18n, wp.blocks, wp.element, wp.blockEditor, wp.components);

/***/ }),
/* 51 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(52), __esModule: true };

/***/ }),
/* 52 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(53);
module.exports = __webpack_require__(0).Object.keys;


/***/ }),
/* 53 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.14 Object.keys(O)
var toObject = __webpack_require__(13);
var $keys = __webpack_require__(11);

__webpack_require__(39)('keys', function () {
  return function keys(it) {
    return $keys(toObject(it));
  };
});


/***/ }),
/* 54 */
/***/ (function(module, exports, __webpack_require__) {

// false -> Array#indexOf
// true  -> Array#includes
var toIObject = __webpack_require__(6);
var toLength = __webpack_require__(55);
var toAbsoluteIndex = __webpack_require__(56);
module.exports = function (IS_INCLUDES) {
  return function ($this, el, fromIndex) {
    var O = toIObject($this);
    var length = toLength(O.length);
    var index = toAbsoluteIndex(fromIndex, length);
    var value;
    // Array#includes uses SameValueZero equality algorithm
    // eslint-disable-next-line no-self-compare
    if (IS_INCLUDES && el != el) while (length > index) {
      value = O[index++];
      // eslint-disable-next-line no-self-compare
      if (value != value) return true;
    // Array#indexOf ignores holes, Array#includes - not
    } else for (;length > index; index++) if (IS_INCLUDES || index in O) {
      if (O[index] === el) return IS_INCLUDES || index || 0;
    } return !IS_INCLUDES && -1;
  };
};


/***/ }),
/* 55 */
/***/ (function(module, exports, __webpack_require__) {

// 7.1.15 ToLength
var toInteger = __webpack_require__(24);
var min = Math.min;
module.exports = function (it) {
  return it > 0 ? min(toInteger(it), 0x1fffffffffffff) : 0; // pow(2, 53) - 1 == 9007199254740991
};


/***/ }),
/* 56 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(24);
var max = Math.max;
var min = Math.min;
module.exports = function (index, length) {
  index = toInteger(index);
  return index < 0 ? max(index + length, 0) : min(index, length);
};


/***/ }),
/* 57 */
/***/ (function(module, exports) {

module.exports = function (it) {
  if (typeof it != 'function') throw TypeError(it + ' is not a function!');
  return it;
};


/***/ }),
/* 58 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(59), __esModule: true };

/***/ }),
/* 59 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(60);
__webpack_require__(65);
module.exports = __webpack_require__(33).f('iterator');


/***/ }),
/* 60 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var $at = __webpack_require__(61)(true);

// 21.1.3.27 String.prototype[@@iterator]()
__webpack_require__(43)(String, 'String', function (iterated) {
  this._t = String(iterated); // target
  this._i = 0;                // next index
// 21.1.5.2.1 %StringIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var index = this._i;
  var point;
  if (index >= O.length) return { value: undefined, done: true };
  point = $at(O, index);
  this._i += point.length;
  return { value: point, done: false };
});


/***/ }),
/* 61 */
/***/ (function(module, exports, __webpack_require__) {

var toInteger = __webpack_require__(24);
var defined = __webpack_require__(23);
// true  -> String#at
// false -> String#codePointAt
module.exports = function (TO_STRING) {
  return function (that, pos) {
    var s = String(defined(that));
    var i = toInteger(pos);
    var l = s.length;
    var a, b;
    if (i < 0 || i >= l) return TO_STRING ? '' : undefined;
    a = s.charCodeAt(i);
    return a < 0xd800 || a > 0xdbff || i + 1 === l || (b = s.charCodeAt(i + 1)) < 0xdc00 || b > 0xdfff
      ? TO_STRING ? s.charAt(i) : a
      : TO_STRING ? s.slice(i, i + 2) : (a - 0xd800 << 10) + (b - 0xdc00) + 0x10000;
  };
};


/***/ }),
/* 62 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var create = __webpack_require__(31);
var descriptor = __webpack_require__(16);
var setToStringTag = __webpack_require__(32);
var IteratorPrototype = {};

// 25.1.2.1.1 %IteratorPrototype%[@@iterator]()
__webpack_require__(7)(IteratorPrototype, __webpack_require__(10)('iterator'), function () { return this; });

module.exports = function (Constructor, NAME, next) {
  Constructor.prototype = create(IteratorPrototype, { next: descriptor(1, next) });
  setToStringTag(Constructor, NAME + ' Iterator');
};


/***/ }),
/* 63 */
/***/ (function(module, exports, __webpack_require__) {

var dP = __webpack_require__(4);
var anObject = __webpack_require__(12);
var getKeys = __webpack_require__(11);

module.exports = __webpack_require__(5) ? Object.defineProperties : function defineProperties(O, Properties) {
  anObject(O);
  var keys = getKeys(Properties);
  var length = keys.length;
  var i = 0;
  var P;
  while (length > i) dP.f(O, P = keys[i++], Properties[P]);
  return O;
};


/***/ }),
/* 64 */
/***/ (function(module, exports, __webpack_require__) {

var document = __webpack_require__(1).document;
module.exports = document && document.documentElement;


/***/ }),
/* 65 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(66);
var global = __webpack_require__(1);
var hide = __webpack_require__(7);
var Iterators = __webpack_require__(30);
var TO_STRING_TAG = __webpack_require__(10)('toStringTag');

var DOMIterables = ('CSSRuleList,CSSStyleDeclaration,CSSValueList,ClientRectList,DOMRectList,DOMStringList,' +
  'DOMTokenList,DataTransferItemList,FileList,HTMLAllCollection,HTMLCollection,HTMLFormElement,HTMLSelectElement,' +
  'MediaList,MimeTypeArray,NamedNodeMap,NodeList,PaintRequestList,Plugin,PluginArray,SVGLengthList,SVGNumberList,' +
  'SVGPathSegList,SVGPointList,SVGStringList,SVGTransformList,SourceBufferList,StyleSheetList,TextTrackCueList,' +
  'TextTrackList,TouchList').split(',');

for (var i = 0; i < DOMIterables.length; i++) {
  var NAME = DOMIterables[i];
  var Collection = global[NAME];
  var proto = Collection && Collection.prototype;
  if (proto && !proto[TO_STRING_TAG]) hide(proto, TO_STRING_TAG, NAME);
  Iterators[NAME] = Iterators.Array;
}


/***/ }),
/* 66 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

var addToUnscopables = __webpack_require__(67);
var step = __webpack_require__(68);
var Iterators = __webpack_require__(30);
var toIObject = __webpack_require__(6);

// 22.1.3.4 Array.prototype.entries()
// 22.1.3.13 Array.prototype.keys()
// 22.1.3.29 Array.prototype.values()
// 22.1.3.30 Array.prototype[@@iterator]()
module.exports = __webpack_require__(43)(Array, 'Array', function (iterated, kind) {
  this._t = toIObject(iterated); // target
  this._i = 0;                   // next index
  this._k = kind;                // kind
// 22.1.5.2.1 %ArrayIteratorPrototype%.next()
}, function () {
  var O = this._t;
  var kind = this._k;
  var index = this._i++;
  if (!O || index >= O.length) {
    this._t = undefined;
    return step(1);
  }
  if (kind == 'keys') return step(0, index);
  if (kind == 'values') return step(0, O[index]);
  return step(0, [index, O[index]]);
}, 'values');

// argumentsList[@@iterator] is %ArrayProto_values% (9.4.4.6, 9.4.4.7)
Iterators.Arguments = Iterators.Array;

addToUnscopables('keys');
addToUnscopables('values');
addToUnscopables('entries');


/***/ }),
/* 67 */
/***/ (function(module, exports) {

module.exports = function () { /* empty */ };


/***/ }),
/* 68 */
/***/ (function(module, exports) {

module.exports = function (done, value) {
  return { value: value, done: !!done };
};


/***/ }),
/* 69 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(70), __esModule: true };

/***/ }),
/* 70 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(71);
__webpack_require__(76);
__webpack_require__(77);
__webpack_require__(78);
module.exports = __webpack_require__(0).Symbol;


/***/ }),
/* 71 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// ECMAScript 6 symbols shim
var global = __webpack_require__(1);
var has = __webpack_require__(2);
var DESCRIPTORS = __webpack_require__(5);
var $export = __webpack_require__(3);
var redefine = __webpack_require__(44);
var META = __webpack_require__(72).KEY;
var $fails = __webpack_require__(9);
var shared = __webpack_require__(26);
var setToStringTag = __webpack_require__(32);
var uid = __webpack_require__(15);
var wks = __webpack_require__(10);
var wksExt = __webpack_require__(33);
var wksDefine = __webpack_require__(34);
var enumKeys = __webpack_require__(73);
var isArray = __webpack_require__(74);
var anObject = __webpack_require__(12);
var isObject = __webpack_require__(8);
var toIObject = __webpack_require__(6);
var toPrimitive = __webpack_require__(28);
var createDesc = __webpack_require__(16);
var _create = __webpack_require__(31);
var gOPNExt = __webpack_require__(75);
var $GOPD = __webpack_require__(47);
var $DP = __webpack_require__(4);
var $keys = __webpack_require__(11);
var gOPD = $GOPD.f;
var dP = $DP.f;
var gOPN = gOPNExt.f;
var $Symbol = global.Symbol;
var $JSON = global.JSON;
var _stringify = $JSON && $JSON.stringify;
var PROTOTYPE = 'prototype';
var HIDDEN = wks('_hidden');
var TO_PRIMITIVE = wks('toPrimitive');
var isEnum = {}.propertyIsEnumerable;
var SymbolRegistry = shared('symbol-registry');
var AllSymbols = shared('symbols');
var OPSymbols = shared('op-symbols');
var ObjectProto = Object[PROTOTYPE];
var USE_NATIVE = typeof $Symbol == 'function';
var QObject = global.QObject;
// Don't use setters in Qt Script, https://github.com/zloirock/core-js/issues/173
var setter = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;

// fallback for old Android, https://code.google.com/p/v8/issues/detail?id=687
var setSymbolDesc = DESCRIPTORS && $fails(function () {
  return _create(dP({}, 'a', {
    get: function () { return dP(this, 'a', { value: 7 }).a; }
  })).a != 7;
}) ? function (it, key, D) {
  var protoDesc = gOPD(ObjectProto, key);
  if (protoDesc) delete ObjectProto[key];
  dP(it, key, D);
  if (protoDesc && it !== ObjectProto) dP(ObjectProto, key, protoDesc);
} : dP;

var wrap = function (tag) {
  var sym = AllSymbols[tag] = _create($Symbol[PROTOTYPE]);
  sym._k = tag;
  return sym;
};

var isSymbol = USE_NATIVE && typeof $Symbol.iterator == 'symbol' ? function (it) {
  return typeof it == 'symbol';
} : function (it) {
  return it instanceof $Symbol;
};

var $defineProperty = function defineProperty(it, key, D) {
  if (it === ObjectProto) $defineProperty(OPSymbols, key, D);
  anObject(it);
  key = toPrimitive(key, true);
  anObject(D);
  if (has(AllSymbols, key)) {
    if (!D.enumerable) {
      if (!has(it, HIDDEN)) dP(it, HIDDEN, createDesc(1, {}));
      it[HIDDEN][key] = true;
    } else {
      if (has(it, HIDDEN) && it[HIDDEN][key]) it[HIDDEN][key] = false;
      D = _create(D, { enumerable: createDesc(0, false) });
    } return setSymbolDesc(it, key, D);
  } return dP(it, key, D);
};
var $defineProperties = function defineProperties(it, P) {
  anObject(it);
  var keys = enumKeys(P = toIObject(P));
  var i = 0;
  var l = keys.length;
  var key;
  while (l > i) $defineProperty(it, key = keys[i++], P[key]);
  return it;
};
var $create = function create(it, P) {
  return P === undefined ? _create(it) : $defineProperties(_create(it), P);
};
var $propertyIsEnumerable = function propertyIsEnumerable(key) {
  var E = isEnum.call(this, key = toPrimitive(key, true));
  if (this === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key)) return false;
  return E || !has(this, key) || !has(AllSymbols, key) || has(this, HIDDEN) && this[HIDDEN][key] ? E : true;
};
var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(it, key) {
  it = toIObject(it);
  key = toPrimitive(key, true);
  if (it === ObjectProto && has(AllSymbols, key) && !has(OPSymbols, key)) return;
  var D = gOPD(it, key);
  if (D && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key])) D.enumerable = true;
  return D;
};
var $getOwnPropertyNames = function getOwnPropertyNames(it) {
  var names = gOPN(toIObject(it));
  var result = [];
  var i = 0;
  var key;
  while (names.length > i) {
    if (!has(AllSymbols, key = names[i++]) && key != HIDDEN && key != META) result.push(key);
  } return result;
};
var $getOwnPropertySymbols = function getOwnPropertySymbols(it) {
  var IS_OP = it === ObjectProto;
  var names = gOPN(IS_OP ? OPSymbols : toIObject(it));
  var result = [];
  var i = 0;
  var key;
  while (names.length > i) {
    if (has(AllSymbols, key = names[i++]) && (IS_OP ? has(ObjectProto, key) : true)) result.push(AllSymbols[key]);
  } return result;
};

// 19.4.1.1 Symbol([description])
if (!USE_NATIVE) {
  $Symbol = function Symbol() {
    if (this instanceof $Symbol) throw TypeError('Symbol is not a constructor!');
    var tag = uid(arguments.length > 0 ? arguments[0] : undefined);
    var $set = function (value) {
      if (this === ObjectProto) $set.call(OPSymbols, value);
      if (has(this, HIDDEN) && has(this[HIDDEN], tag)) this[HIDDEN][tag] = false;
      setSymbolDesc(this, tag, createDesc(1, value));
    };
    if (DESCRIPTORS && setter) setSymbolDesc(ObjectProto, tag, { configurable: true, set: $set });
    return wrap(tag);
  };
  redefine($Symbol[PROTOTYPE], 'toString', function toString() {
    return this._k;
  });

  $GOPD.f = $getOwnPropertyDescriptor;
  $DP.f = $defineProperty;
  __webpack_require__(46).f = gOPNExt.f = $getOwnPropertyNames;
  __webpack_require__(17).f = $propertyIsEnumerable;
  __webpack_require__(35).f = $getOwnPropertySymbols;

  if (DESCRIPTORS && !__webpack_require__(14)) {
    redefine(ObjectProto, 'propertyIsEnumerable', $propertyIsEnumerable, true);
  }

  wksExt.f = function (name) {
    return wrap(wks(name));
  };
}

$export($export.G + $export.W + $export.F * !USE_NATIVE, { Symbol: $Symbol });

for (var es6Symbols = (
  // 19.4.2.2, 19.4.2.3, 19.4.2.4, 19.4.2.6, 19.4.2.8, 19.4.2.9, 19.4.2.10, 19.4.2.11, 19.4.2.12, 19.4.2.13, 19.4.2.14
  'hasInstance,isConcatSpreadable,iterator,match,replace,search,species,split,toPrimitive,toStringTag,unscopables'
).split(','), j = 0; es6Symbols.length > j;)wks(es6Symbols[j++]);

for (var wellKnownSymbols = $keys(wks.store), k = 0; wellKnownSymbols.length > k;) wksDefine(wellKnownSymbols[k++]);

$export($export.S + $export.F * !USE_NATIVE, 'Symbol', {
  // 19.4.2.1 Symbol.for(key)
  'for': function (key) {
    return has(SymbolRegistry, key += '')
      ? SymbolRegistry[key]
      : SymbolRegistry[key] = $Symbol(key);
  },
  // 19.4.2.5 Symbol.keyFor(sym)
  keyFor: function keyFor(sym) {
    if (!isSymbol(sym)) throw TypeError(sym + ' is not a symbol!');
    for (var key in SymbolRegistry) if (SymbolRegistry[key] === sym) return key;
  },
  useSetter: function () { setter = true; },
  useSimple: function () { setter = false; }
});

$export($export.S + $export.F * !USE_NATIVE, 'Object', {
  // 19.1.2.2 Object.create(O [, Properties])
  create: $create,
  // 19.1.2.4 Object.defineProperty(O, P, Attributes)
  defineProperty: $defineProperty,
  // 19.1.2.3 Object.defineProperties(O, Properties)
  defineProperties: $defineProperties,
  // 19.1.2.6 Object.getOwnPropertyDescriptor(O, P)
  getOwnPropertyDescriptor: $getOwnPropertyDescriptor,
  // 19.1.2.7 Object.getOwnPropertyNames(O)
  getOwnPropertyNames: $getOwnPropertyNames,
  // 19.1.2.8 Object.getOwnPropertySymbols(O)
  getOwnPropertySymbols: $getOwnPropertySymbols
});

// 24.3.2 JSON.stringify(value [, replacer [, space]])
$JSON && $export($export.S + $export.F * (!USE_NATIVE || $fails(function () {
  var S = $Symbol();
  // MS Edge converts symbol values to JSON as {}
  // WebKit converts symbol values to JSON as null
  // V8 throws on boxed symbols
  return _stringify([S]) != '[null]' || _stringify({ a: S }) != '{}' || _stringify(Object(S)) != '{}';
})), 'JSON', {
  stringify: function stringify(it) {
    var args = [it];
    var i = 1;
    var replacer, $replacer;
    while (arguments.length > i) args.push(arguments[i++]);
    $replacer = replacer = args[1];
    if (!isObject(replacer) && it === undefined || isSymbol(it)) return; // IE8 returns string on undefined
    if (!isArray(replacer)) replacer = function (key, value) {
      if (typeof $replacer == 'function') value = $replacer.call(this, key, value);
      if (!isSymbol(value)) return value;
    };
    args[1] = replacer;
    return _stringify.apply($JSON, args);
  }
});

// 19.4.3.4 Symbol.prototype[@@toPrimitive](hint)
$Symbol[PROTOTYPE][TO_PRIMITIVE] || __webpack_require__(7)($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
// 19.4.3.5 Symbol.prototype[@@toStringTag]
setToStringTag($Symbol, 'Symbol');
// 20.2.1.9 Math[@@toStringTag]
setToStringTag(Math, 'Math', true);
// 24.3.3 JSON[@@toStringTag]
setToStringTag(global.JSON, 'JSON', true);


/***/ }),
/* 72 */
/***/ (function(module, exports, __webpack_require__) {

var META = __webpack_require__(15)('meta');
var isObject = __webpack_require__(8);
var has = __webpack_require__(2);
var setDesc = __webpack_require__(4).f;
var id = 0;
var isExtensible = Object.isExtensible || function () {
  return true;
};
var FREEZE = !__webpack_require__(9)(function () {
  return isExtensible(Object.preventExtensions({}));
});
var setMeta = function (it) {
  setDesc(it, META, { value: {
    i: 'O' + ++id, // object ID
    w: {}          // weak collections IDs
  } });
};
var fastKey = function (it, create) {
  // return primitive with prefix
  if (!isObject(it)) return typeof it == 'symbol' ? it : (typeof it == 'string' ? 'S' : 'P') + it;
  if (!has(it, META)) {
    // can't set metadata to uncaught frozen object
    if (!isExtensible(it)) return 'F';
    // not necessary to add metadata
    if (!create) return 'E';
    // add missing metadata
    setMeta(it);
  // return object ID
  } return it[META].i;
};
var getWeak = function (it, create) {
  if (!has(it, META)) {
    // can't set metadata to uncaught frozen object
    if (!isExtensible(it)) return true;
    // not necessary to add metadata
    if (!create) return false;
    // add missing metadata
    setMeta(it);
  // return hash weak collections IDs
  } return it[META].w;
};
// add metadata on freeze-family methods calling
var onFreeze = function (it) {
  if (FREEZE && meta.NEED && isExtensible(it) && !has(it, META)) setMeta(it);
  return it;
};
var meta = module.exports = {
  KEY: META,
  NEED: false,
  fastKey: fastKey,
  getWeak: getWeak,
  onFreeze: onFreeze
};


/***/ }),
/* 73 */
/***/ (function(module, exports, __webpack_require__) {

// all enumerable object keys, includes symbols
var getKeys = __webpack_require__(11);
var gOPS = __webpack_require__(35);
var pIE = __webpack_require__(17);
module.exports = function (it) {
  var result = getKeys(it);
  var getSymbols = gOPS.f;
  if (getSymbols) {
    var symbols = getSymbols(it);
    var isEnum = pIE.f;
    var i = 0;
    var key;
    while (symbols.length > i) if (isEnum.call(it, key = symbols[i++])) result.push(key);
  } return result;
};


/***/ }),
/* 74 */
/***/ (function(module, exports, __webpack_require__) {

// 7.2.2 IsArray(argument)
var cof = __webpack_require__(38);
module.exports = Array.isArray || function isArray(arg) {
  return cof(arg) == 'Array';
};


/***/ }),
/* 75 */
/***/ (function(module, exports, __webpack_require__) {

// fallback for IE11 buggy Object.getOwnPropertyNames with iframe and window
var toIObject = __webpack_require__(6);
var gOPN = __webpack_require__(46).f;
var toString = {}.toString;

var windowNames = typeof window == 'object' && window && Object.getOwnPropertyNames
  ? Object.getOwnPropertyNames(window) : [];

var getWindowNames = function (it) {
  try {
    return gOPN(it);
  } catch (e) {
    return windowNames.slice();
  }
};

module.exports.f = function getOwnPropertyNames(it) {
  return windowNames && toString.call(it) == '[object Window]' ? getWindowNames(it) : gOPN(toIObject(it));
};


/***/ }),
/* 76 */
/***/ (function(module, exports) {



/***/ }),
/* 77 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(34)('asyncIterator');


/***/ }),
/* 78 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(34)('observable');


/***/ }),
/* 79 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(80);
module.exports = __webpack_require__(0).Object.getPrototypeOf;


/***/ }),
/* 80 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.2.9 Object.getPrototypeOf(O)
var toObject = __webpack_require__(13);
var $getPrototypeOf = __webpack_require__(45);

__webpack_require__(39)('getPrototypeOf', function () {
  return function getPrototypeOf(it) {
    return $getPrototypeOf(toObject(it));
  };
});


/***/ }),
/* 81 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(82), __esModule: true };

/***/ }),
/* 82 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(83);
var $Object = __webpack_require__(0).Object;
module.exports = function defineProperty(it, key, desc) {
  return $Object.defineProperty(it, key, desc);
};


/***/ }),
/* 83 */
/***/ (function(module, exports, __webpack_require__) {

var $export = __webpack_require__(3);
// 19.1.2.4 / 15.2.3.6 Object.defineProperty(O, P, Attributes)
$export($export.S + $export.F * !__webpack_require__(5), 'Object', { defineProperty: __webpack_require__(4).f });


/***/ }),
/* 84 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(85), __esModule: true };

/***/ }),
/* 85 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(86);
module.exports = __webpack_require__(0).Object.setPrototypeOf;


/***/ }),
/* 86 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.3.19 Object.setPrototypeOf(O, proto)
var $export = __webpack_require__(3);
$export($export.S, 'Object', { setPrototypeOf: __webpack_require__(87).set });


/***/ }),
/* 87 */
/***/ (function(module, exports, __webpack_require__) {

// Works with __proto__ only. Old v8 can't work with null proto objects.
/* eslint-disable no-proto */
var isObject = __webpack_require__(8);
var anObject = __webpack_require__(12);
var check = function (O, proto) {
  anObject(O);
  if (!isObject(proto) && proto !== null) throw TypeError(proto + ": can't set as prototype!");
};
module.exports = {
  set: Object.setPrototypeOf || ('__proto__' in {} ? // eslint-disable-line
    function (test, buggy, set) {
      try {
        set = __webpack_require__(40)(Function.call, __webpack_require__(47).f(Object.prototype, '__proto__').set, 2);
        set(test, []);
        buggy = !(test instanceof Array);
      } catch (e) { buggy = true; }
      return function setPrototypeOf(O, proto) {
        check(O, proto);
        if (buggy) O.__proto__ = proto;
        else set(O, proto);
        return O;
      };
    }({}, false) : undefined),
  check: check
};


/***/ }),
/* 88 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(89), __esModule: true };

/***/ }),
/* 89 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(90);
var $Object = __webpack_require__(0).Object;
module.exports = function create(P, D) {
  return $Object.create(P, D);
};


/***/ }),
/* 90 */
/***/ (function(module, exports, __webpack_require__) {

var $export = __webpack_require__(3);
// 19.1.2.2 / 15.2.3.5 Object.create(O [, Properties])
$export($export.S, 'Object', { create: __webpack_require__(31) });


/***/ }),
/* 91 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__ = __webpack_require__(92);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_get_prototype_of__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_get_prototype_of___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_get_prototype_of__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_classCallCheck__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_classCallCheck___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_classCallCheck__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_createClass__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_createClass___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_createClass__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_possibleConstructorReturn__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_possibleConstructorReturn___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_possibleConstructorReturn__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_inherits__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_inherits___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_inherits__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_classnames__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_6_classnames___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_6_classnames__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_7__components_inspector__ = __webpack_require__(97);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_8__components_blogitem__ = __webpack_require__(98);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_9__components_icons__ = __webpack_require__(99);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__styles_style_scss__ = __webpack_require__(100);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_10__styles_style_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_10__styles_style_scss__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__styles_editor_scss__ = __webpack_require__(101);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_11__styles_editor_scss___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_11__styles_editor_scss__);






/**
 * BLOCK: prosys Blocks BlogItem
 */

// Import block dependencies and components





// Import CSS



// Internationalization
var __ = wp.i18n.__;

// Extend component

var Component = wp.element.Component;

// Register block

var registerBlockType = wp.blocks.registerBlockType;

// Register editor components

var _wp$editor = wp.editor,
    RichText = _wp$editor.RichText,
    AlignmentToolbar = _wp$editor.AlignmentToolbar,
    BlockControls = _wp$editor.BlockControls,
    BlockAlignmentToolbar = _wp$editor.BlockAlignmentToolbar,
    MediaUpload = _wp$editor.MediaUpload;

// Register components

var _wp$components = wp.components,
    Button = _wp$components.Button,
    SelectControl = _wp$components.SelectControl;


var ALLOWED_MEDIA_TYPES = ['image'];

var PSBlogItemBlock = function (_Component) {
	__WEBPACK_IMPORTED_MODULE_5_babel_runtime_helpers_inherits___default()(PSBlogItemBlock, _Component);

	function PSBlogItemBlock() {
		__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_classCallCheck___default()(this, PSBlogItemBlock);

		return __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_possibleConstructorReturn___default()(this, (PSBlogItemBlock.__proto__ || __WEBPACK_IMPORTED_MODULE_1_babel_runtime_core_js_object_get_prototype_of___default()(PSBlogItemBlock)).apply(this, arguments));
	}

	__WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_createClass___default()(PSBlogItemBlock, [{
		key: 'render',
		value: function render() {
			var _this2 = this;

			// Setup the attributes
			var _props = this.props,
			    _props$attributes = _props.attributes,
			    blogItemName = _props$attributes.blogItemName,
			    blogItemTitle = _props$attributes.blogItemTitle,
			    blogItemContent = _props$attributes.blogItemContent,
			    blogItemAlignment = _props$attributes.blogItemAlignment,
			    blogItemImgURL = _props$attributes.blogItemImgURL,
			    blogItemImgID = _props$attributes.blogItemImgID,
			    blogItemBackgroundColor = _props$attributes.blogItemBackgroundColor,
			    blogItemTextColor = _props$attributes.blogItemTextColor,
			    blogItemFontSize = _props$attributes.blogItemFontSize,
			    blogItemCiteAlign = _props$attributes.blogItemCiteAlign,
			    attributes = _props.attributes,
			    isSelected = _props.isSelected,
			    editable = _props.editable,
			    className = _props.className,
			    setAttributes = _props.setAttributes;


			var onSelectImage = function onSelectImage(img) {
				setAttributes({
					blogItemImgID: img.id,
					blogItemImgURL: img.url
				});
			};

			return [
			// Show the alignment toolbar on focus
			React.createElement(
				BlockControls,
				{ key: 'controls' },
				React.createElement(AlignmentToolbar, {
					value: blogItemAlignment,
					onChange: function onChange(value) {
						return setAttributes({ blogItemAlignment: value });
					}
				})
			),
			// Show the block controls on focus
			React.createElement(__WEBPACK_IMPORTED_MODULE_7__components_inspector__["a" /* default */], __WEBPACK_IMPORTED_MODULE_0_babel_runtime_helpers_extends___default()({ setAttributes: setAttributes }, this.props)),
			// Show the block markup in the editor
			React.createElement(
				__WEBPACK_IMPORTED_MODULE_8__components_blogitem__["a" /* default */],
				this.props,
				React.createElement(RichText, {
					tagName: 'div',
					multiline: 'p',
					placeholder: __('Add blog Item text...', 'prosys-blocks'),
					keepPlaceholderOnFocus: true,
					value: blogItemContent,
					formattingControls: ['bold', 'italic', 'strikethrough', 'link'],
					className: __WEBPACK_IMPORTED_MODULE_6_classnames___default()('ps-blogItem-text'),
					style: {
						textAlign: blogItemAlignment
					},
					onChange: function onChange(value) {
						return setAttributes({ blogItemContent: value });
					}
				}),
				React.createElement(
					'div',
					{ 'class': 'ps-blogItem-info' },
					React.createElement(
						'div',
						{ 'class': 'ps-blogItem-avatar-wrap' },
						React.createElement(
							'div',
							{ 'class': 'ps-blogItem-image-wrap' },
							React.createElement(MediaUpload, {
								buttonProps: {
									className: 'change-image'
								},
								onSelect: function onSelect(img) {
									return setAttributes({
										blogItemImgID: img.id,
										blogItemImgURL: img.url
									});
								},
								allowed: ALLOWED_MEDIA_TYPES,
								type: 'image',
								value: blogItemImgID,
								render: function render(_ref) {
									var open = _ref.open;
									return React.createElement(
										Button,
										{ onClick: open },
										!blogItemImgID ? __WEBPACK_IMPORTED_MODULE_9__components_icons__["a" /* default */].upload : React.createElement('img', {
											'class': 'ps-blogItem-avatar',
											src: blogItemImgURL,
											alt: 'avatar'
										})
									);
								}
							})
						)
					),
					React.createElement(RichText, {
						tagName: 'h2',
						placeholder: __('Add name', 'prosys-blocks'),
						keepPlaceholderOnFocus: true,
						value: blogItemName,
						className: 'ps-blogItem-name',
						style: {
							color: blogItemTextColor
						},
						onChange: function onChange(value) {
							return _this2.props.setAttributes({ blogItemName: value });
						}
					}),
					React.createElement(RichText, {
						tagName: 'small',
						placeholder: __('Add title', 'prosys-blocks'),
						keepPlaceholderOnFocus: true,
						value: blogItemTitle,
						className: 'ps-blogItem-title',
						style: {
							color: blogItemTextColor
						},
						onChange: function onChange(value) {
							return _this2.props.setAttributes({ blogItemTitle: value });
						}
					})
				)
			)];
		}
	}]);

	return PSBlogItemBlock;
}(Component);

// Register the block


registerBlockType('prosys-blocks/ps-blogItem', {
	title: __('PS blogItem', 'prosys-blocks'),
	description: __('Add a user blogItem with a name and title.', 'prosys-blocks'),
	icon: 'format-quote',
	category: 'prosys-blocks',
	keywords: [__('Blog Item', 'prosys-blocks'), __('quote', 'prosys-blocks'), __('prosys', 'prosys-blocks')],
	attributes: {
		blogItemName: {
			type: 'array',
			selector: '.ps-blogItem-name',
			source: 'children'
		},
		blogItemTitle: {
			type: 'array',
			selector: '.ps-blogItem-title',
			source: 'children'
		},
		blogItemContent: {
			type: 'array',
			selector: '.ps-blogItem-text',
			source: 'children'
		},
		blogItemAlignment: {
			type: 'string'
		},
		blogItemImgURL: {
			type: 'string',
			source: 'attribute',
			attribute: 'src',
			selector: 'img'
		},
		blogItemImgID: {
			type: 'number'
		},
		blogItemBackgroundColor: {
			type: 'string',
			default: '#f2f2f2'
		},
		blogItemTextColor: {
			type: 'string',
			default: '#32373c'
		},
		blogItemFontSize: {
			type: 'number',
			default: 18
		},
		blogItemCiteAlign: {
			type: 'string',
			default: 'left-aligned'
		}
	},

	// Render the block components
	edit: PSBlogItemBlock,

	// Save the attributes and markup
	save: function save(props) {

		// Setup the attributes
		var _props$attributes2 = props.attributes,
		    blogItemName = _props$attributes2.blogItemName,
		    blogItemTitle = _props$attributes2.blogItemTitle,
		    blogItemContent = _props$attributes2.blogItemContent,
		    blogItemAlignment = _props$attributes2.blogItemAlignment,
		    blogItemImgURL = _props$attributes2.blogItemImgURL,
		    blogItemImgID = _props$attributes2.blogItemImgID,
		    blogItemBackgroundColor = _props$attributes2.blogItemBackgroundColor,
		    blogItemTextColor = _props$attributes2.blogItemTextColor,
		    blogItemFontSize = _props$attributes2.blogItemFontSize,
		    blogItemCiteAlign = _props$attributes2.blogItemCiteAlign;

		// Save the block markup for the front end

		return React.createElement(
			__WEBPACK_IMPORTED_MODULE_8__components_blogitem__["a" /* default */],
			props,
			React.createElement(RichText.Content, {
				tagName: 'div',
				className: 'ps-blogItem-text',
				style: {
					textAlign: blogItemAlignment
				},
				value: blogItemContent
			}),
			React.createElement(
				'div',
				{ 'class': 'ps-blogItem-info' },
				blogItemImgURL && React.createElement(
					'div',
					{ 'class': 'ps-blogItem-avatar-wrap' },
					React.createElement(
						'div',
						{ 'class': 'ps-blogItem-image-wrap' },
						React.createElement('img', {
							'class': 'ps-blogItem-avatar',
							src: blogItemImgURL,
							alt: 'avatar'
						})
					)
				),
				blogItemName && React.createElement(RichText.Content, {
					tagName: 'h2',
					className: 'ps-blogItem-name',
					style: {
						color: blogItemTextColor
					},
					value: blogItemName
				}),
				blogItemTitle && React.createElement(RichText.Content, {
					tagName: 'small',
					className: 'ps-blogItem-title',
					style: {
						color: blogItemTextColor
					},
					value: blogItemTitle
				})
			)
		);
	}
});

/***/ }),
/* 92 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


exports.__esModule = true;

var _assign = __webpack_require__(93);

var _assign2 = _interopRequireDefault(_assign);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

exports.default = _assign2.default || function (target) {
  for (var i = 1; i < arguments.length; i++) {
    var source = arguments[i];

    for (var key in source) {
      if (Object.prototype.hasOwnProperty.call(source, key)) {
        target[key] = source[key];
      }
    }
  }

  return target;
};

/***/ }),
/* 93 */
/***/ (function(module, exports, __webpack_require__) {

module.exports = { "default": __webpack_require__(94), __esModule: true };

/***/ }),
/* 94 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(95);
module.exports = __webpack_require__(0).Object.assign;


/***/ }),
/* 95 */
/***/ (function(module, exports, __webpack_require__) {

// 19.1.3.1 Object.assign(target, source)
var $export = __webpack_require__(3);

$export($export.S + $export.F, 'Object', { assign: __webpack_require__(96) });


/***/ }),
/* 96 */
/***/ (function(module, exports, __webpack_require__) {

"use strict";

// 19.1.2.1 Object.assign(target, source, ...)
var getKeys = __webpack_require__(11);
var gOPS = __webpack_require__(35);
var pIE = __webpack_require__(17);
var toObject = __webpack_require__(13);
var IObject = __webpack_require__(37);
var $assign = Object.assign;

// should work with symbols and should have deterministic property order (V8 bug)
module.exports = !$assign || __webpack_require__(9)(function () {
  var A = {};
  var B = {};
  // eslint-disable-next-line no-undef
  var S = Symbol();
  var K = 'abcdefghijklmnopqrst';
  A[S] = 7;
  K.split('').forEach(function (k) { B[k] = k; });
  return $assign({}, A)[S] != 7 || Object.keys($assign({}, B)).join('') != K;
}) ? function assign(target, source) { // eslint-disable-line no-unused-vars
  var T = toObject(target);
  var aLen = arguments.length;
  var index = 1;
  var getSymbols = gOPS.f;
  var isEnum = pIE.f;
  while (aLen > index) {
    var S = IObject(arguments[index++]);
    var keys = getSymbols ? getKeys(S).concat(getSymbols(S)) : getKeys(S);
    var length = keys.length;
    var j = 0;
    var key;
    while (length > j) if (isEnum.call(S, key = keys[j++])) T[key] = S[key];
  } return T;
} : $assign;


/***/ }),
/* 97 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits__);





/**
 * Inspector Controls
 */

// Setup the block
var __ = wp.i18n.__;
var Component = wp.element.Component;

// Import block components

var _wp$editor = wp.editor,
    InspectorControls = _wp$editor.InspectorControls,
    BlockDescription = _wp$editor.BlockDescription,
    ColorPalette = _wp$editor.ColorPalette,
    PanelColorSettings = _wp$editor.PanelColorSettings;

// Import Inspector components

var _wp$components = wp.components,
    Toolbar = _wp$components.Toolbar,
    Button = _wp$components.Button,
    PanelBody = _wp$components.PanelBody,
    PanelRow = _wp$components.PanelRow,
    FormToggle = _wp$components.FormToggle,
    RangeControl = _wp$components.RangeControl,
    SelectControl = _wp$components.SelectControl;

/**
 * Create an Inspector Controls wrapper Component
 */

var Inspector = function (_Component) {
	__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits___default()(Inspector, _Component);

	function Inspector(props) {
		__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck___default()(this, Inspector);

		return __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn___default()(this, (Inspector.__proto__ || __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of___default()(Inspector)).apply(this, arguments));
	}

	__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass___default()(Inspector, [{
		key: 'render',
		value: function render() {
			var _this2 = this;

			// Cite Alignment Options
			var citeAlignOptions = [{ value: 'left-aligned', label: __('Left Aligned') }, { value: 'right-aligned', label: __('Right Aligned') }];

			var backgroundColors = [{ color: '#00d1b2', name: 'teal' }, { color: '#3373dc', name: 'royal blue' }, { color: '#209cef', name: 'sky blue' }, { color: '#22d25f', name: 'green' }, { color: '#ffdd57', name: 'yellow' }, { color: '#ff3860', name: 'pink' }, { color: '#7941b6', name: 'purple' }, { color: '#392F43', name: 'black' }];

			// Setup the attributes
			var _props = this.props,
			    _props$attributes = _props.attributes,
			    blogItemName = _props$attributes.blogItemName,
			    blogItemTitle = _props$attributes.blogItemTitle,
			    blogItemContent = _props$attributes.blogItemContent,
			    blogItemAlignment = _props$attributes.blogItemAlignment,
			    blogItemImgURL = _props$attributes.blogItemImgURL,
			    blogItemImgID = _props$attributes.blogItemImgID,
			    blogItemBackgroundColor = _props$attributes.blogItemBackgroundColor,
			    blogItemTextColor = _props$attributes.blogItemTextColor,
			    blogItemFontSize = _props$attributes.blogItemFontSize,
			    blogItemCiteAlign = _props$attributes.blogItemCiteAlign,
			    isSelected = _props.isSelected,
			    className = _props.className,
			    setAttributes = _props.setAttributes;

			// Update color values

			var onChangeBackgroundColor = function onChangeBackgroundColor(value) {
				return setAttributes({ blogItemBackgroundColor: value });
			};
			var onChangeTextColor = function onChangeTextColor(value) {
				return setAttributes({ blogItemTextColor: value });
			};

			return React.createElement(
				InspectorControls,
				{ key: 'inspector' },
				React.createElement(
					PanelBody,
					null,
					React.createElement(RangeControl, {
						label: __('Font Size'),
						value: blogItemFontSize,
						onChange: function onChange(value) {
							return _this2.props.setAttributes({ blogItemFontSize: value });
						},
						min: 14,
						max: 24,
						step: 1
					}),
					React.createElement(SelectControl, {
						label: __('Cite Alignment'),
						description: __('Left or right align the cite name and title.'),
						options: citeAlignOptions,
						value: blogItemCiteAlign,
						onChange: function onChange(value) {
							return _this2.props.setAttributes({ blogItemCiteAlign: value });
						}
					}),
					React.createElement(PanelColorSettings, {
						title: __('Background Color'),
						initialOpen: false,
						colorSettings: [{
							value: blogItemBackgroundColor,
							colors: backgroundColors,
							onChange: onChangeBackgroundColor,
							label: __('Background Color')

						}]
					}),
					React.createElement(PanelColorSettings, {
						title: __('Text Color'),
						initialOpen: false,
						colorSettings: [{
							value: blogItemTextColor,
							onChange: onChangeTextColor,
							label: __('Text Color')
						}]
					})
				)
			);
		}
	}]);

	return Inspector;
}(Component);

/* harmony default export */ __webpack_exports__["a"] = (Inspector);

/***/ }),
/* 98 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of__ = __webpack_require__(18);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck__ = __webpack_require__(19);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits__ = __webpack_require__(22);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_classnames__ = __webpack_require__(48);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_5_classnames___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_5_classnames__);
throw new Error("Cannot find module \"./../../../utils/helper\"");





/**
 * blogItem Block Wrapper
 */

// Setup the block
var Component = wp.element.Component;

// Import block dependencies and components




/**
 * Create a blogItem wrapper Component
 */

var BlogItem = function (_Component) {
	__WEBPACK_IMPORTED_MODULE_4_babel_runtime_helpers_inherits___default()(BlogItem, _Component);

	function BlogItem(props) {
		__WEBPACK_IMPORTED_MODULE_1_babel_runtime_helpers_classCallCheck___default()(this, BlogItem);

		return __WEBPACK_IMPORTED_MODULE_3_babel_runtime_helpers_possibleConstructorReturn___default()(this, (BlogItem.__proto__ || __WEBPACK_IMPORTED_MODULE_0_babel_runtime_core_js_object_get_prototype_of___default()(BlogItem)).apply(this, arguments));
	}

	__WEBPACK_IMPORTED_MODULE_2_babel_runtime_helpers_createClass___default()(BlogItem, [{
		key: 'render',
		value: function render() {

			// Setup the attributes
			var _props$attributes = this.props.attributes,
			    blogItemAlignment = _props$attributes.blogItemAlignment,
			    blogItemImgURL = _props$attributes.blogItemImgURL,
			    blogItemBackgroundColor = _props$attributes.blogItemBackgroundColor,
			    blogItemTextColor = _props$attributes.blogItemTextColor,
			    blogItemFontSize = _props$attributes.blogItemFontSize,
			    blogItemCiteAlign = _props$attributes.blogItemCiteAlign;


			return React.createElement(
				'div',
				{
					style: {
						backgroundColor: blogItemBackgroundColor,
						color: blogItemTextColor
					},
					className: __WEBPACK_IMPORTED_MODULE_5_classnames___default()(this.props.className, blogItemCiteAlign, { 'ps-has-avatar': blogItemImgURL }, 'ps-font-size-' + blogItemFontSize, 'ps-block-blogItem')
				},
				this.props.children
			);
		}
	}]);

	return BlogItem;
}(Component);

/* harmony default export */ __webpack_exports__["a"] = (BlogItem);

/***/ }),
/* 99 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
var icons = {};

icons.upload = React.createElement(
    'svg',
    { width: '20px', height: '20px', viewBox: '0 0 100 100', xmlns: 'http://www.w3.org/2000/svg' },
    React.createElement('path', { d: 'm77.945 91.453h-72.371c-3.3711 0-5.5742-2.3633-5.5742-5.2422v-55.719c0-3.457 2.1172-6.0703 5.5742-6.0703h44.453v11.051l-38.98-0.003906v45.008h60.977v-17.133l11.988-0.007812v22.875c0 2.8789-2.7812 5.2422-6.0664 5.2422z'
    }),
    React.createElement('path', { d: 'm16.543 75.48l23.25-22.324 10.441 9.7773 11.234-14.766 5.5039 10.539 0.039063 16.773z'
    }),
    React.createElement('path', { d: 'm28.047 52.992c-3.168 0-5.7422-2.5742-5.7422-5.7461 0-3.1758 2.5742-5.75 5.7422-5.75 3.1797 0 5.7539 2.5742 5.7539 5.75 0 3.1719-2.5742 5.7461-5.7539 5.7461z'
    }),
    React.createElement('path', { d: 'm84.043 30.492v22.02h-12.059l-0.015625-22.02h-15.852l21.941-21.945 21.941 21.945z'
    })
);

/* harmony default export */ __webpack_exports__["a"] = (icons);

/***/ }),
/* 100 */
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: Error: Missing binding D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\vendor\\win32-x64-72\\binding.node\nNode Sass could not find a binding for your current environment: Windows 64-bit with Node.js 12.x\n\nFound bindings for the following environments:\n  - Windows 64-bit with Node.js 7.x\n\nThis usually happens because your environment has changed since running `npm install`.\nRun `npm rebuild node-sass` to download the binding for your current environment.\n    at module.exports (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\lib\\binding.js:15:13)\n    at Object.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\lib\\index.js:14:35)\n    at Module._compile (internal/modules/cjs/loader.js:955:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:991:10)\n    at Module.load (internal/modules/cjs/loader.js:811:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:723:14)\n    at Module.require (internal/modules/cjs/loader.js:848:19)\n    at require (internal/modules/cjs/helpers.js:74:18)\n    at Object.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\sass-loader\\lib\\loader.js:3:14)\n    at Module._compile (internal/modules/cjs/loader.js:955:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:991:10)\n    at Module.load (internal/modules/cjs/loader.js:811:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:723:14)\n    at Module.require (internal/modules/cjs/loader.js:848:19)\n    at require (internal/modules/cjs/helpers.js:74:18)\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:18:17)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:365:2)\n    at NormalModule.doBuild (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:182:3)\n    at NormalModule.build (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:275:15)\n    at Compilation.buildModule (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:157:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:460:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:195:19\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:367:11\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:172:11\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:32:11)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:365:2)\n    at NormalModule.doBuild (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:182:3)\n    at NormalModule.build (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:275:15)\n    at Compilation.buildModule (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:157:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:460:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:243:5\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:94:13\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\tapable\\lib\\Tapable.js:268:11\n    at NormalModuleFactory.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\CompatibilityPlugin.js:52:5)\n    at NormalModuleFactory.applyPluginsAsyncWaterfall (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\tapable\\lib\\Tapable.js:272:13)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:69:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:196:7\n    at processTicksAndRejections (internal/process/task_queues.js:76:11)");

/***/ }),
/* 101 */
/***/ (function(module, exports) {

throw new Error("Module build failed: ModuleBuildError: Module build failed: Error: Missing binding D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\vendor\\win32-x64-72\\binding.node\nNode Sass could not find a binding for your current environment: Windows 64-bit with Node.js 12.x\n\nFound bindings for the following environments:\n  - Windows 64-bit with Node.js 7.x\n\nThis usually happens because your environment has changed since running `npm install`.\nRun `npm rebuild node-sass` to download the binding for your current environment.\n    at module.exports (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\lib\\binding.js:15:13)\n    at Object.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\node-sass\\lib\\index.js:14:35)\n    at Module._compile (internal/modules/cjs/loader.js:955:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:991:10)\n    at Module.load (internal/modules/cjs/loader.js:811:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:723:14)\n    at Module.require (internal/modules/cjs/loader.js:848:19)\n    at require (internal/modules/cjs/helpers.js:74:18)\n    at Object.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\sass-loader\\lib\\loader.js:3:14)\n    at Module._compile (internal/modules/cjs/loader.js:955:30)\n    at Object.Module._extensions..js (internal/modules/cjs/loader.js:991:10)\n    at Module.load (internal/modules/cjs/loader.js:811:32)\n    at Function.Module._load (internal/modules/cjs/loader.js:723:14)\n    at Module.require (internal/modules/cjs/loader.js:848:19)\n    at require (internal/modules/cjs/helpers.js:74:18)\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:18:17)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:365:2)\n    at NormalModule.doBuild (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:182:3)\n    at NormalModule.build (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:275:15)\n    at Compilation.buildModule (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:157:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:460:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:195:19\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:367:11\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:172:11\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:32:11)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:165:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:176:18\n    at loadLoader (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\loadLoader.js:47:3)\n    at iteratePitchingLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:169:2)\n    at runLoaders (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\loader-runner\\lib\\LoaderRunner.js:365:2)\n    at NormalModule.doBuild (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:182:3)\n    at NormalModule.build (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModule.js:275:15)\n    at Compilation.buildModule (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:157:10)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\Compilation.js:460:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:243:5\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:94:13\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\tapable\\lib\\Tapable.js:268:11\n    at NormalModuleFactory.<anonymous> (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\CompatibilityPlugin.js:52:5)\n    at NormalModuleFactory.applyPluginsAsyncWaterfall (D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\tapable\\lib\\Tapable.js:272:13)\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:69:10\n    at D:\\xampp\\htdocs\\plugins-factory\\wp-content\\plugins\\prosys-power-block\\node_modules\\webpack\\lib\\NormalModuleFactory.js:196:7\n    at processTicksAndRejections (internal/process/task_queues.js:76:11)");

/***/ })
/******/ ]);
//# sourceMappingURL=blocks.editor.js.map