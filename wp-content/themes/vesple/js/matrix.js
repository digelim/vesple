function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance"); }

function _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === "[object Arguments]")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _correlation(d1, d2) {
  var min = Math.min,
      pow = Math.pow,
      sqrt = Math.sqrt;

  var add = function add(a, b) {
    return a + b;
  };

  var n = min(d1.length, d2.length);

  if (n === 0) {
    return 0;
  }

  var _ref = [d1.slice(0, n), d2.slice(0, n)];
  d1 = _ref[0];
  d2 = _ref[1];

  var _map = [d1, d2].map(function (l) {
    return l.reduce(add);
  }),
      _map2 = _slicedToArray(_map, 2),
      sum1 = _map2[0],
      sum2 = _map2[1];

  var _map3 = [d1, d2].map(function (l) {
    return l.reduce(function (a, b) {
      return a + pow(b, 2);
    }, 0);
  }),
      _map4 = _slicedToArray(_map3, 2),
      pow1 = _map4[0],
      pow2 = _map4[1];

  var mulSum = d1.map(function (n, i) {
    return n * d2[i];
  }).reduce(add);
  var dense = sqrt((pow1 - pow(sum1, 2) / n) * (pow2 - pow(sum2, 2) / n));

  if (dense === 0) {
    return 0;
  }

  return (mulSum - sum1 * sum2 / n) / dense;
};

function _average(array) {
  var sum;
  var average = 0;

  if (array.length) {
    sum = array.reduce(function (a, b) {
      return a + b;
    });

    average = sum / array.length;
  }

  return average;
};

function _standardDeviation(array) {
  var average = _average(array);

  var diffs = array.map(function (value) {
    return value - average;
  });

  var squareDiffs = diffs.map(function (diff) {
    return diff * diff;
  });

  var avgSquareDiff = _average(squareDiffs);

  return Math.sqrt(avgSquareDiff);
};

function _sumProduct(a, b) {
  return math.sum(math.dotMultiply(a, b));
}

function _covariance() {
	var bias = false,
		args,
		opts,
		nArgs,
		len,
		deltas,
		delta,
		means,
		C,
		cov,
		arr,
		N, r, A, B, sum, val,
		i, j, n;

	args = Array.prototype.slice.call( arguments );
	nArgs = args.length;

	if ( isObject( args[nArgs-1] ) ) {
		opts = args.pop();
		nArgs = nArgs - 1;
		if ( opts.hasOwnProperty( 'bias' ) ) {
			if ( typeof opts.bias !== 'boolean' ) {
				throw new TypeError( 'covariance()::invalid input argument. Bias option must be a boolean.' );
			}
			bias = opts.bias;
		}
	}

	if ( !nArgs ) {
		throw new Error( 'covariance()::insufficient input arguments. Must provide array arguments.' );
	}

	for ( i = 0; i < nArgs; i++ ) {
		if ( !Array.isArray( args[i] ) ) {
			throw new TypeError( 'covariance()::invalid input argument. Must provide array arguments.' );
		}
	}

	if ( Array.isArray( args[0][0] ) ) {
		// If the first argument is an array of arrays, calculate the covariance over the nested arrays, disregarding any other arguments...
		args = args[ 0 ];
	}
	nArgs = args.length;
	len = args[ 0 ].length;

	for ( i = 1; i < nArgs; i++ ) {
		if ( args[i].length !== len ) {
			throw new Error( 'covariance()::invalid input argument. All arrays must have equal length.' );
		}
	}

	deltas = new Array( nArgs );
	means = new Array( nArgs );
	C = new Array( nArgs );
	cov = new Array( nArgs );
	for ( i = 0; i < nArgs; i++ ) {
		means[ i ] = args[ i ][ 0 ];
		arr = new Array( nArgs );
		for ( j = 0; j < nArgs; j++ ) {
			arr[ j ] = 0;
		}
		C[ i ] = arr;
		cov[ i ] = arr.slice();
	}
	if ( len < 2 ) {
		return cov;
	}

	for ( n = 1; n < len; n++ ) {

		N = n + 1;
		r = n / N;

		for ( i = 0; i < nArgs; i++ ) {
			deltas[ i ] = args[ i ][ n ] - means[ i ];
		}

		for ( i = 0; i < nArgs; i++ ) {
			arr = C[ i ];
			delta = deltas[ i ];
			for ( j = i; j < nArgs; j++ ) {
				A = arr[ j ];
				B = r * delta * deltas[ j ];
				sum = A + B;
				if ( i !== j ) {
					C[ j ][ i ] = sum;
				}
				arr[ j ] = sum;
			}
		}

		for ( i = 0; i < nArgs; i++ ) {
			means[ i ] += deltas[ i ] / N;
		}
	}
	n = N - 1;
	if ( bias ) {
		n = N;
	}
	for ( i = 0; i < nArgs; i++ ) {
		arr = C[ i ];
		for ( j = i; j < nArgs; j++ ) {
			val = arr[ j ] / n;
			cov[ i ][ j ] = val;
			if ( i !== j ) {
				cov[ j ][ i ] = val;
			}
		}
	}
	return cov;
}
