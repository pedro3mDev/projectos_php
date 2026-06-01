<script>
	$(function() {
		'use strict';
		init_roles_permissions_v1();


		function init_roles_permissions_v1(roleid, user_changed) {
			"use strict";

			roleid = typeof(roleid) == 'undefined' ? $('select[name="role_v"]').val() : roleid;
			var isedit = $('.member > input[name="isedit"]');

			// Check if user is edit view and user has changed the dropdown permission if not only return
			if (isedit.length > 0 && typeof(roleid) !== 'undefined' && typeof(user_changed) == 'undefined') {
				return;
			}

			// Administrators does not have permissions
			if ($('input[name="administrator"]').prop('checked') === true) {
				return;
			}

			// Last if the roleid is blank return
			if (roleid === '') {
				return;
			}

			// Get all permissions
			var permissions = $('table.roles').find('tr');
			requestGetJSON('hr_profile/hr_role_changed/' + roleid).done(function(response) {

				permissions.find('.capability').not('[data-not-applicable="true"]').prop('checked', false).trigger('change');

				$.each(permissions, function() {
					var row = $(this);
					$.each(response, function(feature, obj) {
						if (row.data('name') == feature) {
							$.each(obj, function(i, capability) {
								row.find('input[id="' + feature + '_' + capability + '"]').prop('checked', true);
								if (capability == 'view') {
									row.find('[data-can-view]').change();
								} else if (capability == 'view_own') {
									row.find('[data-can-view-own]').change();
								}
							});
						}
					});
				});
			});
		}


	});
</script>

<script>
	$(document).ready(function() {
		$('#conselho').change(function() {
			const conselhoId = $(this).val(); // Obtém o valor selecionado

			if (conselhoId) {

				requestGetJSON('hr_profile/listar_pelorios/' + conselhoId).done(function(response) {
					// Verifica se o status retornado é 'true'
					if (response.status) {
						// alert("teste")
						var pelorios = response.data;
						var select = $('#peloriosSelect');

						// Limpa as opções existentes antes de adicionar novas
						select.empty();

						// Adiciona a opção padrão
						select.append('<option value="">Selecione um Pelório</option>');

						// Adiciona as opções dos pelórios
						pelorios.forEach(function(pelorio) {
							select.append('<option value="' + pelorio.id + '">' + pelorio.nome + '</option>');
						});

					} else {
						alert('Erro ao carregar os pelorios.');
					}
				});
			} else {
				alert("Selecione uma Conselho para ver os Pelorios.")
			}
		});

		$('#peloriosSelect').change(function() {
			const pelorioId = $(this).val(); // Obtém o valor selecionado
			// alert("teste")

			if (pelorioId) {

				requestGetJSON('hr_profile/listar_direcoes/' + pelorioId).done(function(response) {
					// Verifica se o status retornado é 'true'

					if (response.status) {
						var direcoes = response.data;
						var select = $('#direcoesSelect');

						// Limpa as opções existentes antes de adicionar novas
						select.empty();

						// Adiciona a opção padrão
						select.append('<option value="">Selecione uma direcoes</option>');

						// Adiciona as opções dos pelórios
						direcoes.forEach(function(direcao) {
							select.append('<option value="' + direcao.id + '">' + direcao.nome + '</option>');
						});

					} else {
						alert('Erro ao carregar os direcoes.');
					}
				});
			} else {
				alert("Selecione uma Pelório para ver os direcoes.")
			}
		});

		$('#direcoesSelect').change(function() {
			const direcoesId = $(this).val(); // Obtém o valor selecionado
			// alert("teste")

			if (direcoesId) {

				requestGetJSON('hr_profile/listar_departments/' + direcoesId).done(function(response) {
					// Verifica se o status retornado é 'true'

					if (response.status) {
						var departamentos = response.data;
						var select = $('#departamentoSelect');

						// Limpa as opções existentes antes de adicionar novas
						select.empty();

						// Adiciona a opção padrão
						select.append('<option value="">Selecione um departamento</option>');

						// Adiciona as opções dos pelórios
						departamentos.forEach(function(departamento) {
							select.append('<option value="' + departamento.departmentid + '">' + departamento.name + '</option>');
						});

					} else {
						alert('Erro ao carregar os departamento.');
					}
				});
			} else {
				alert("Selecione uma direcoes para ver os departamento.")
			}
		});

		$('#departamentoSelect').change(function() {
			const departmentId = $(this).val(); // Obtém o valor selecionado

			if (departmentId) {
				// alert(departmentId)

				requestGetJSON('hr_profile/listar_seccoes/' + departmentId).done(function(response) {
					// Verifica se o status retornado é 'true'

					if (response.status) {
						var seccoes = response.data;
						var select = $('#seccoesSelect');

						// Limpa as opções existentes antes de adicionar novas
						select.empty();

						// Adiciona a opção padrão
						select.append('<option value="">Selecione uma seccoes</option>');

						// Adiciona as opções dos pelórios
						seccoes.forEach(function(seccao) {
							select.append('<option value="' + seccao.id + '">' + seccao.nome + '</option>');
						});

					} else {
						alert('Erro ao carregar os seccoes.');
					}
				});
			} else {
				alert("Selecione uma departamento para ver os seccoes .")
			}
		});
	});
</script>