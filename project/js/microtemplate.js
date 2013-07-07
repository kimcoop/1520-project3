/* Based on Carlos Gavina's microtemplate.js */

var microtemplate = function( templName ) {
  var regex = /\{([^}]+)\}/g,
    template = null,
    loadTempl, parse, g;
  loadTempl = function( a ) {
    xmlHttp.get({ 
      url: a, 
      async: false, 
      callback: function( response ) {
        template = response;
        console.log(' response should be template: ');
        console.debug( template );
      }
    });
    return template;
  };
  parse = function( a, b ) {
    for ( var e, f, c = a.match( regex ), d = len = c.length; d-- ;) 
      e = c[d], f = e.slice(1, e.length - 1), null != b[f] && (a = a.replace(e, b[f]));
    return a
  };
  render = function( a ) {
    console.log(' template: ');
    console.debug( template);
    return a ? parse( template, a ) : template
  };
  setTemplate = function( a ) {
    template = a;
    return g;
  };
  (function( a ) {
    null === template && null != a ? loadTempl( a ) : template = a
  })( templName );
  return g = {
    render: render,
    setTemplate: setTemplate,
    getTemplate: function() {
      console.log('getting template');
      return template;
    }
  }
};