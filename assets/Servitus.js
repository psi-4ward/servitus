var Servitus = new Class({

	Implements: [Options],

	options: {
		ajaxExecutorUrl: 'system/modules/servitus/bin/ajaxExecutor.php'
	},

	runStep: function(token,stepID)
	{
		var self=this;
		AjaxRequest.displayBox('Running Step '+stepID);
		var r = new Request.JSON(
		{
			url: this.options.ajaxExecutorUrl,
			onSuccess: function(json,txt)
			{
				document.id('ServitusStatus').adopt(new Elements.from('<div>'+json.content+'</div>'));

				if(json.runAgain)
				{
					self.runStep(token,stepID);
				}
				else
				{
					AjaxRequest.hideBox();
				}
			},
			onError: function(txt,error)
			{
				document.id('ServitusStatus').adopt(new Elements.from('<p class="tl_error">'+txt+'</div>'));
				AjaxRequest.hideBox();
			}

		}).get({'token': token, 'sid': stepID});
	}
});
