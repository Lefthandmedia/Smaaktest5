/**
 * @author Lefthandmedia <ralph@lefthandmedia.com>
 */

myObject = {

	a: 'test1',
	b: 'test2',
	c: 'x',

	go: function() {
		console.debug(this);
	},

	go2: function() {
		console.log(a);
		console.log(b);
		console.log(this.c);
		console.debug(this);
	}
};

globaltest = function() {
	console.log('dit');
	return 'dat';

}

var scopeObj = (function() {
	a = 'global';
	var b = 'test2';
	var c = 'x';

	this.c = 'test3';
	_this = this;

	console.debug(this.c);

	this.go = function() {
		console.log(a);
		console.log(b);
		console.log(_this.c);
		console.debug(this);
	};

	go2 = function() {
		console.log(a);
		console.log(b);
		console.log(c);
		console.debug(this);
	};

	var go3 = function() {
		console.log(a);
		console.log(b);
		console.log(c);
		console.debug(this);
	};

	go4 = globaltest();
	console.log(go4);

	return {go: go,
		//go2: go2,
		go3: go3,
		go4:go4
	};


})();

console.log(a);
// obj = myObject();

// console.log(scopeObj);

scopeObj.goo = function() {
	console.debug(this);
}


 scopeObj.go4;
// scopeObj.go2();
// scopeObj.go3();
// scopeObj.goo();