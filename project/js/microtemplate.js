/** microtemplate.js * by Carlos Gavina * @carlosgavina * hello@carlosgavina.com * v0.4 */
var microtemplate = function (h) {
  var i = /\{([^}]+)\}/g,
    b = null,
    c, d, g;
  c = function (a) {
    xmlHttp.get( a, function( a ) {
      b = str = a;
      return b;
    })
  };
  d = function (a, b) {
    for (var e, f, c = a.match(i), d = len = c.length; d--;) e = c[d], f = e.slice(1, e.length - 1), null != b[f] && (a = a.replace(e, b[f]));
    return a
  };
  render = function (a) {
    return a ? d(b, a) : b
  };
  setTemplate = function (a) {
    b = a;
    return g
  };
  (function (a) {
    null === b && null != a ? c(a) : b = a
  })(h);
  return g = {
    render: render,
    setTemplate: setTemplate,
    getTemplate: function () {
      return b
    }
  }
};