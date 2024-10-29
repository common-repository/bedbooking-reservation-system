function bb_initWidget() {
	const widgets = document.getElementsByClassName('bb-widget-holder')

	for (let i = 0; i < widgets.length; i++) {
		const widget = widgets[i]

		if (widget.getAttribute('bb-widget-api-key')) {
			const widgetId = widget.getAttribute('id')
			const widgetKey = widget.getAttribute('bb-widget-api-key')
			const widgetType = widget.getAttribute('bb-widget-type')
			const widgetFloating = widget.getAttribute('bb-widget-floating')
			const widgetRoom = widget.getAttribute('bb-widget-room')

			if(widgetType === 'simple'){
				w1('init', {targetElementId: widgetId, widgetId: widgetKey, type:widgetType, staticWidget: widgetFloating})
			}

			if(widgetType === 'room') {
				w1('init', {targetElementId: widgetId, widgetId: widgetKey, type:widgetType, room: String(widgetRoom)})
			}

			if(widgetType === 'calendar'){
				w1('init', {targetElementId: widgetId, widgetId: widgetKey, type:widgetType})
			}

		}
	}
}

bb_initWidget();
