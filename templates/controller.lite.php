<?php
	// CRUD CONTROLLER PARA: %Model%
	class %Item%Controller extends %BaseController%
	{
		//listar los elementos de %Model%
		function index()
		{
			$this->%lcaseModels% = %Model%::all();
		}
		
		//crear un nuevo elemento de %Model%
		function add()
		{
			if (Input::hasPost('%lcaseModel%')) {
				$%lcaseModel% = new %Model%(Input::post('%lcaseModel%'));
				if ($%lcaseModel%->create()) {
					Input::delete('%lcaseModel%');
					Flash::valid('Elemento creado exitosamente');
				} else {
					Flash::error('Elemento no pudo ser creado.');
				}
			}
		}

		//editar un elemento de %Model%
		function edit($id)
		{
			$%lcaseModel% = %Model%::get($id);
			if (Input::hasPost('%lcaseModel%')) {
				if ($%lcaseModel%->update(Input::post('%lcaseModel%'))) {
					Flash::valid('Elemento actualizado exitosamente');
				} else {
					Flash::error('Elemento no pudo ser actualizado.');
				}
			}
			$this->%lcaseModel% = $%lcaseModel%;
		}
		
		function delete($id)
		{
			if (%Model%::delete($id)) {
				Flash::valid('Elemento eliminado exitosamente');
			} else {
				Flash::error('Elemento no pudo ser eliminado.');
			}
			Redirect::to(); //redirección a index
		}
		
		function show($id)
		{
			$this->%lcaseModel% = %Model%::get($id);
		}
	
	}
