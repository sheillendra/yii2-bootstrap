<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace sheillendra\bootstrap;

use yii\helpers\Html;
use yii\bootstrap\BootstrapPluginAsset;
use yii\bootstrap\Widget;
/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the [[begin()]] and [[end()]] calls of NavBar
 * is treated as the content of the navbar. You may use widgets such as [[Nav]]
 * or [[\yii\widgets\Menu]] to build up such content. For example,
 *
 * ```php
 * use yii\bootstrap\NavBar;
 * use yii\widgets\Menu;
 *
 * NavBar::begin(['brandLabel' => 'NavBar Test']);
 * echo Nav::widget([
 *     'items' => [
 *         ['label' => 'Home', 'url' => ['/site/index']],
 *         ['label' => 'About', 'url' => ['/site/about']],
 *     ],
 * ]);
 * NavBar::end();
 * ```
 *
 * @see http://getbootstrap.com/components/#navbar
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @since 2.0
 */
class NavBar extends Widget
{
	/**
	 * @var string the text of the brand. Note that this is not HTML-encoded.
	 * @see http://getbootstrap.com/components/#navbar
	 */
	public $brandLabel;
	/**
	 * @param array|string $url the URL for the brand's hyperlink tag. This parameter will be processed by [[Html::url()]]
	 * and will be used for the "href" attribute of the brand link. Defaults to site root.
	 */
	public $brandUrl = '/';
	/**
	 * @var array the HTML attributes of the brand link.
	 */
	public $brandOptions = [];
	/**
	 * @var string text to show for screen readers for the button to toggle the navbar.
	 */
	public $screenReaderToggleText = 'Toggle navigation';
	/**
	 * @var bool whether the navbar content should be included in a `container` div which adds left and right padding.
	 * Set this to false for a 100% width navbar.
	 */
	public $padded = true;

	public $collapse = true;
	/**
	 * Initializes the widget.
	 */

	public $inverse = false;
	public $fixed = false;
	public $position = 'top';
	public $containerOptions=[];
	public $headerOptions=[];
	public $notCollapseOptions=[];
	public function init()
	{
		parent::init();
		$this->clientOptions = false;
		Html::addCssClass($this->options, 'navbar');

		if ($this->inverse) {
			Html::addCssClass($this->options, 'navbar-inverse');
		}else{
			Html::addCssClass($this->options, 'navbar-default');
		}

		if($this->fixed){
			Html::addCssClass($this->options, 'navbar-fixed-'.$this->position);
		}

		Html::addCssClass($this->brandOptions, 'navbar-brand');

		echo Html::beginTag('div', $this->options);
		if ($this->padded) {
			if(empty($this->containerOptions['class'])){
				Html::addCssClass($this->containerOptions,'container');
			}
			echo Html::beginTag('div', $this->containerOptions);
		}

		Html::addCssClass($this->headerOptions,'navbar-header');
		echo Html::beginTag('div', $this->headerOptions);

		echo $this->renderToggleButton();
		if ($this->brandLabel !== null) {
			echo Html::a($this->brandLabel, $this->brandUrl, $this->brandOptions);
		}
		echo Html::endTag('div');

		if($this->collapse){
			echo Html::beginTag('div', ['class' => "collapse navbar-collapse navbar-{$this->options['id']}-collapse"]);
		}else{
			echo Html::beginTag('div',$this->notCollapseOptions);
		}
	}

	/**
	 * Renders the widget.
	 */
	public function run()
	{

		echo Html::endTag('div');
		if ($this->padded) {
			echo Html::endTag('div');
		}
		echo Html::endTag('div');
		BootstrapPluginAsset::register($this->getView());
	}

	/**
	 * Renders collapsible toggle button.
	 * @return string the rendering toggle button.
	 */
	protected function renderToggleButton()
	{
		$bar = Html::tag('span', '', ['class' => 'icon-bar']);
		$screenReader = '<span class="sr-only">'.$this->screenReaderToggleText.'</span>';
		return Html::button("{$screenReader}\n{$bar}\n{$bar}\n{$bar}", [
			'class' => 'navbar-toggle',
			'data-toggle' => 'collapse',
			'data-target' => ".navbar-{$this->options['id']}-collapse",
		]);
	}
}
