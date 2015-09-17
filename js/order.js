function ordenar( tbody, th ) {
	var type = th.className;
	if( type == 'none' ) return;

	if( tbody.sortIndex != undefined ) {
		tbody.sortTh.removeClassName( tbody.sortReverse > 0 ? 'asc' : 'desc' );
	}
	var index = th.cellIndex;
	var r = tbody.sortIndex == index && ! tbody.sortReverse;

	var trs = $A( tbody.rows ).sort( function( a, b ) {
		if( ! a.v ) a.v = new Array();
		if( ! b.v ) b.v = new Array();

		if( ! a.v[index] ) a.v[index] = a.cells[index].innerHTML.norm( type );
		if( ! b.v[index] ) b.v[index] = b.cells[index].innerHTML.norm( type );

		a = a.v[index];
		b = b.v[index];

		return r ? (a<b) - (a>b) : (a>b) - (a<b);
	} );

	for( var i = 0; i < trs.length; i++ ) tbody.appendChild( trs[i] );

	tbody.sortIndex = index;
	tbody.sortReverse = r;
	tbody.sortTh = th;
	th.addClassName( tbody.sortReverse ? 'asc' : 'desc' );
}

// normalize string
String.prototype.norm = function( type ) {
	if( type == 'number' ) return parseFloat( this );
	if( type == 'string' ) return this.toLowerCase();
	if( type == 'date' ) {
		var d = this.split( /[\\\/\-]/ );
		if( d.length < 3 ) return this;
		return d = (d[2].length<3?'19'+d[2]:d[2])+(d[1].length<2?'0'+d[1]:d[1])+(d[0].length<2?'0'+d[0]:d[0])
	}

if( type == 'moneda' ) {
	var pp="";
  var d = this.split( /[$,]/ );
  for(var i=0; i<d.length; i++){ pp=pp+d[i]; }
	if(pp==000) pp=0.01;
  return parseFloat( pp );
 }
	return this;
}


// javascript trigger
Event.observe( window, 'load', function() {
	$$('table.ordenar').each( function( table ) {
		$A( table.getElementsByTagName( 'th' ) ).each( function( th ) {
			Event.observe( th, 'click', function() {
				$A( table.tBodies ).each( function( tbody ) {
					ordenar( tbody, th );
				} );
			} );
		} );
	} );
} );


