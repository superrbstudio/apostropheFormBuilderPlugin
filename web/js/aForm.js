function aFormEditor(options) {
  var labels;
  var editor;
  var builders = {
    input: function()
    {
      return $('<input disabled="true" type="text" />');
    },
    textarea: function()
    {
      return $('<textarea disabled="true"></textarea>');
    },
    address: function()
    {
      return $(
        '<ul class="a-form-editor-address">' +
          '<li><label>' + labels.street1 + '</label><input disabled="true" type="text" class="a-form-editor-street1" /></li>' +
          '<li><label>' + labels.street2 + '</label><input disabled="true" type="text" class="a-form-editor-street2" /></li>' +
          '<li><label>' + labels.city + '</label><input disabled="true" type="text" class="a-form-editor-city" /></li>' +
          '<li><label>' + labels.state + '</label><input disabled="true" type="text" class="a-form-editor-state" /></li>' +
          '<li><label>' + labels.postalCode + '</label><input disabled="true" type="text" class="a-form-editor-postal_code" /></li>' +
          '<li><label>' + labels.country + '</label><input disabled="true" type="text" class="a-form-editor-country" /></li>' +
        '</ul>');
    },
    select: function(fieldsetInfo)
    {
      var html =  
        '<ul class="a-form-editor-select">' +
          '<li class="a-form-editor-select-example">' +
            '<select disabled="true" class="a-form-editor-single-select">' +
              '<option value="">' + labels.chooseOne + '</option>' +
              '<option value="example1">1</option>' +
              '<option value="example2">2</option>' +
              '<option value="example3">3</option>' +
            '</select>' +
          '</li>' +
          '<li class="a-form-editor-select-editor">' + '</li>';
        '</ul>';
      var element = $(html);
      element.find('.a-form-editor-select-editor').append(newListEditor(fieldsetInfo));
      return element;
    },
    select_radio: function(fieldsetInfo)
    {
      var html =
        '<ul class="a-form-editor-select-radio">' +
          '<li class="a-form-editor-select-radio-example">' +
            '<ul>' +
              '<li><input type="radio" disabled="true" value="example1" />1</li>' +
              '<li><input type="radio" disabled="true" value="example2" />2</li>' +
              '<li><input type="radio" disabled="true" value="example3" />3</li>' +
            '</ul>' +
          '</li>' +
          '<li class="a-form-editor-select-editor">' + '</li>' +
        '</ul>';
      var element = $(html);
      element.find('.a-form-editor-select-editor').append(newListEditor(fieldsetInfo));
      return element;
    },
    select_checkbox: function(fieldsetInfo)
    {
      var html = 
        '<ul class="a-form-editor-select-checkbox">' +
          '<li class="a-form-editor-select-checkbox-example">' +
            '<ul>' +
              '<li><input type="checkbox" disabled="true" value="example1" />1</li>' +
              '<li><input type="checkbox" disabled="true" value="example2" />2</li>' +
              '<li><input type="checkbox" disabled="true" value="example3" />3</li>' +
            '</ul>' +
          '</li>' +
          '<li class="a-form-editor-select-editor">' + '</li>' +
        '</ul>';
      var element = $(html);
      element.find('.a-form-editor-select-editor').append(newListEditor(fieldsetInfo));
      return element;
    }
  };
    
  function init(options)
  {
    // Private 
    labels = options.labels;
    var fieldsetInfos = options.fieldsetInfos;
    /// Private 
    editor = $('<div class="a-form-editor"></div>');
    var i;
    var list = $('<ul class="a-form-editor-fieldsets"></ul>');
    list.sortable();
//    list.disableSelection();
		apostrophe.log('before fieldsetInfos');
		apostrophe.log('length is ' + fieldsetInfos.length);
    for (i = 0; (i < fieldsetInfos.length); i++)
    {
			apostrophe.log('i is ' + i);
      var fieldsetInfo = fieldsetInfos[i];
      list.append(newFieldset(fieldsetInfo));
    }
		apostrophe.log('after fieldsetInfos');
    editor.append(list);
    var add = newButton(labels.add, 'a-add');
    $(add).click(function() {
      list.append(newFieldset({ type: 'input', label: '', id: '' }));
      return false;
    });
		apostrophe.log('before append');
    editor.append(add);
  }
  
  function newFieldset(fieldsetInfo)
  {
    var item = builders[fieldsetInfo.type](fieldsetInfo);
    var wrapper = $('<li class="a-form-editor-item-meta"><ul><li class="a-form-editor-labels"><label>' + labels.label + '</label><input class="a-form-editor-label" /><input type="hidden" class="a-form-editor-id" /></li></ul></li>');
    var wrapperUl = wrapper.find('ul');
    var types = $('<select class="a-form-editor-type"></select>');
    var type;
    for (type in builders)
    {
      var option = $('<option></option>');
      option.attr('value', type);
      option.html(labels[type]);
      types.append(option);
      types.val(fieldsetInfo.type);
    }
		wrapper.find('.a-form-editor-label').val(fieldsetInfo.label);
		wrapper.find('.a-form-editor-id').val(fieldsetInfo.id);
    $(types).change(function() {
      var item = $(types).closest('.a-form-editor-item-meta').find('.a-form-editor-item');
      item.html('');
      item.append(builders[types.val()]({ 'type': types.val(), 'options': []}));
    });
    var typesLi = $('<li class="a-form-editor-types"></li>');
    typesLi.append(types);
    wrapperUl.prepend(typesLi);
    var itemLi = $('<li class="a-form-editor-item"></li>');
    itemLi.append(item);
    wrapperUl.append(itemLi);
    var removeLi = $('<li class="a-form-editor-remove"></li>');
    var remove = newRemoveButton();
    removeLi.append(remove);
    $(remove).click(function() {
      $(this).closest('.a-form-editor-item-meta').remove();
    });
    wrapperUl.append(removeLi);
    return wrapper;
  }
  
  function newListEditor(fieldsetInfo)
  {
    var i;
    var list = $('<ul class="a-form-editor-select-items"></ul>');
    for (i = 0; (i < fieldsetInfo.options.length); i++)
    {
      var option = fieldsetInfo.options[i];
      var li = newListItem();
      li.append(newListRemoveButton());
      li.find('.a-form-editor-name').val(option.name);
      li.find('.a-form-editor-value').val(option.value);
      list.append(li);
    }
    var li = newAddToListItem();
    list.append(li);
    list.sortable();
//    list.disableSelection();
    return list;
  }

  function newAddToListItem()
  {
    var li = newListItem();
    li.append(newButton(labels.add, 'a-add'));
    li.find('.a-add').click(function() {
      var li = $(this).closest('.a-form-editor-select-item');
      li.find('.a-add').remove();
      li.append(newListRemoveButton());
      li.closest('.a-form-editor-select-items').append(newAddToListItem());
      return false;
    });
    return li;
  }
  
  function newButton(label, class)
  {
    return $('<a href="#" class="a-btn a-icon ' + class + '">' + label + '<span class="icon"></span></a>');
  }
  
  function newListItem()
  {
    return $('<li class="a-form-editor-select-item">' + labels.name + '<input class="a-form-editor-name" type="text" />' + labels.value + '<input class="a-form-editor-value" type="value" /></li>');
  }
  
  function newRemoveButton()
  {
    return newButton(labels.remove, 'a-remove');
  }
  
  function newListRemoveButton()
  {
    var button = newRemoveButton();
    button.click(function() {
      $(this).closest('.a-form-editor-select-item').remove();
      return false;
    });
    return button;
  }
  
	apostrophe.log('before init');
  init(options);
  apostrophe.log('after init');

  this.getEditor = function()
  {
    return editor;
  };
  
  this.serialize = function()
  {
    var items = editor.find('.a-form-editor-item-meta');
    var i;
    var results = [];
    items.each(function() {
      var item = $(this);
      var result = { type: item.find('.a-form-editor-type').val() };
      var options = item.find('.a-form-editor-select-item');
      var j;
      result.options = [];
			result.label = item.find('.a-form-editor-label').val();
			result.id = item.find('.a-form-editor-id').val();
      for (j = 0; (j < options.length); j++)
      {
        var option = $(options[j]);
        var value = option.find('.a-form-editor-value').val();
        if (value.length)
        {
          result.options[result.options.length] = { name: option.find('.a-form-editor-name').val(), value: option.find('.a-form-editor-value').val() };
        }
      }
      results[results.length] = result;
    });
    return JSON.stringify(results);
  };
}

function aFormEditorExample()
{
	$(function() {
	  var editor = new aFormEditor(
			{
				fieldsetInfos: [
					{
						label: 'Which', 
						// Existing ids can be passed in and will be passed back so we
						// don't lose associations with existing data
						id: 100,
						type: 'select_radio', 
						options: 
							[ 
								{ name: 'One', value: 1 }, 
								{ name: 'Two', value: 2 } 
							]
					}
				], 
				labels: { 
			    chooseOne: 'Choose One', 
			    add: 'Add', 
			    value: 'Value', 
			    name: 'Name', 
			    remove: 'Remove',
			    input: 'Input',
			    textarea: 'Text Area',
			    address: 'Address',
			    select: 'Select Menu',
			    select_radio: 'Select Radio',
			    select_checkbox: 'Select Multiple',
			    street1: 'Street Line 1',
			    street2: 'Street Line 2',
			    city: 'City',
			    state: 'State',
			    postalCode: 'Postal Code',
			    country: 'Country'
	  		}
			});
	  $('.a-form-editor-container').append(editor.getEditor());
	  $('.a-form-editor-save').click(function() {
	    alert(editor.serialize());
	    return false;
	  });
	});
}

function aFormEditorForFormSlot(options)
{
	apostrophe.log('hi');
	var hidden = $(options.selector);
	apostrophe.log('after hidden');
	options.fieldsetInfos = JSON.parse(hidden.val());
	apostrophe.log('after parse');
	var editor = new aFormEditor(options);
	apostrophe.log('after new');
	apostrophe.log('appending to ' + options.appendTo);
	$(options.appendTo).append(editor.getEditor());
	apostrophe.log('after append');
	apostrophe.registerOnSubmit(options.slotId, function (slotId) {
		apostrophe.log('callback on submit');
		hidden.val(editor.serialize());
	});
	apostrophe.log('bye');
}
