<?php

App::import('Behavior', 'CakePtbr.Correios');

class CakePtbrCorreiosCase extends CakeTestCase {

	var $Correios = null;

	function setUp() {
		parent::setUp();
		$this->Correios = new CorreiosBehavior();
	}

	function testValorFrete() {
		$this->assertNotEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(40000, '88000-000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000000', '88888-000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888000', 10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 'peso'), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', -12), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 10, true, -10), ERRO_CORREIOS_PARAMETROS_INVALIDOS);
		$this->assertEqual($this->Correios->valorFrete(CORREIOS_SEDEX, '88000-000', '88888-000', 30.5), ERRO_CORREIOS_EXCESSO_PESO);
		// Dados obtidos dia 21/04/2009
		$correios = $this->Correios->valorFrete(CORREIOS_SEDEX, '88037-100', '88037-100', 10, true, 30, false);
		$correto = array(
			'ufOrigem' => 'SC',
			'ufDestino' => 'SC',
			'capitalOrigem' => true,
			'capitalDestino' => true,
			'valorMaoPropria' => 3.3,
			'valorTarifaValorDeclarado' => 0,
			'valorFrete' => 22.5,
			'valorTotal' => 25.8
		);
		$this->assertEqual($correios, $correto);
	}

	function testEndereco() {
		$correios = $this->Correios->endereco('88037-100');
		$correto = array(
			'logradouro' => 'Rua Acadêmico Reinaldo Consoni',
			'bairro' => 'Santa Mônica',
			'cidade' => 'Florianópolis',
			'uf' => 'SC'
		);
		$this->assertEqual($correios, $correto);
	}

}

?>