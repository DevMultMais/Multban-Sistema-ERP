﻿//  This file is part of the jQuery formatCurrency Plugin.
//
//    The jQuery formatCurrency Plugin is free software: you can redistribute it
//    and/or modify it under the terms of the GNU General Public License as published
//    by the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.

//    The jQuery formatCurrency Plugin is distributed in the hope that it will
//    be useful, but WITHOUT ANY WARRANTY; without even the implied warranty
//    of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU General Public License for more details.
//
//    You should have received a copy of the GNU General Public License along with
//    the jQuery formatCurrency Plugin.  If not, see <http://www.gnu.org/licenses/>.

(function($) {

	$.formatCurrency.regions['pt-BR'] = {
		symbol: '',
		positiveFormat: '%s%n',
		negativeFormat: '-%s%n',
		decimalSymbol: ',',
		digitGroupSymbol: '.',
		groupDigits: true
	};

    $.formatCurrency.regions['pt-BR-QTD'] = {
		symbol: '',
		positiveFormat: '%s%n',
		negativeFormat: '-%s%n',
		decimalSymbol: ',',
		digitGroupSymbol: '.',
		groupDigits: false
	};

    $.formatCurrency.regions['pt-BR-PER'] = {
		symbol: '%',
		positiveFormat: '%n%s',
		negativeFormat: '-%s%n',
		decimalSymbol: ',',
		digitGroupSymbol: '.',
		groupDigits: false
	};

})(jQuery);
