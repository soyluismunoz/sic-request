<?php 
	$path_uri = SR_URI;
	wp_enqueue_style('bootstrap-5-0', $path_uri . "/bootstrap.min.css", false, '5.0', 'all'); 
?>
<div class="container">
	<style>
		.table-bordered td, .table-bordered th {
		    border: 1px solid #dee2e6;
		}
	</style>
	<?php if (!isset($_POST['table'])) { ?>
		<div class="row">
			<div class="col-12">
				<h2 class="text-center"> Formulario consultas Sic </h2>
				<form method="post">
					<input type="hidden" name="table" value="true">
					<div class="row">
						<div class="col-6 my-2">
							<label for="IdOp"> Identificador de Operador</label>
							<input id="IdOp" type="text" class="form-control" placeholder="111" name="identificadorOperador" pattern="[0-9]+">
						</div>
						<div class="col-6 my-2">
							<label for="anioCun"> Año de Radicacion Cun</label>
							<input id="anioCun" type="text" class="form-control" placeholder="13" name="anoRadicacionCun" pattern="[0-9]+">
						</div>
						<div class="col-6 my-2">
							<label for="conCun"> Consecutivo Radicacion Cun</label>
							<input id="conCun" type="text" class="form-control" placeholder="0000589753" name="ConsecutivoRadCun" pattern="[0-9]+">
						</div>
						<div class="col-6 my-2">
							<label for="numRad"> Numero de Radicacion </label>
							<input id="numRad" type="text" class="form-control" placeholder="55564" name="numeroRadicacion" pattern="[0-9]+">
						</div>
						<div class="col-6 my-2">
							<label for="anioRad"> Año de Radicacion </label>
							<input id="anioRad" type="text" class="form-control" placeholder="16" name="anoRadicacion" pattern="[0-9]+">
						</div>
						<div class="col-6 my-2">
							<label for="nameOp"> Nombre Del Operador </label>
							<input id="nameOp" type="text" class="form-control" placeholder="NOMBRE DEL OPERADOR EN LA SIC" name="nombreOperador">
						</div>
						<div class="col-6 my-2">
							<label for="typeId"> Tipo de Identificacion </label>
							<input id="typeId" type="text" class="form-control" placeholder="cc" name="tipoIdentificacion">
						</div>
						<div class="col-6 my-2">
							<label for="numId"> Numero de Identificacion </label>
							<input id="numId" type="text" class="form-control" placeholder="12540985" name="numeroIdentificacion" pattern="[0-9]+">
						</div>
						<div class="col-12 my-2">
							<input type="submit" class="btn btn-danger text-white mx-auto" value="Consultar">
						</div>
					</div>
				</form>
			</div>
		</div>
	<?php } else{ ?>

		<div class="row">
			<form action="" class="my-3">
				<input type="submit" value="Realizar otra consulta" class="btn bg-info btn-sm text-white">
			</form>
			<div class="table-responsive">
				<table class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th class="text-center" scope="col">
								Tipo de Queja Sic
							</th>
							<th class="text-center" scope="col" colspan="4">
								Numero Radicado Cun
							</th>
							<th class="text-center" scope="col" colspan="3">
								Codigo Unico Numerico
							</th>
							<th class="text-center" scope="col">
								Fecha de Asignacion 
							</th>
							<th class="text-center" scope="col">
								Fecha Estimada de Respuesta 
							</th>
							<th class="text-center" scope="col" colspan="2">
								Nombre de la Persona 
							</th>
							<th class="text-center" scope="col" colspan="2">
								Tipo Id Nacional Persona 
							</th>
							<th class="text-center" scope="col">
								Grupo Numero de Identificacion 
							</th>
				            <th class="text-center" scope="col">
								Url 
				            </th>
				            <th class="text-center" scope="col">
								Nombre DE Operador 
				            </th>
				            <th class="text-center" scope="col">
								Descripcion Estado 
				            </th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$res = isset($result['response']['IntegracionCUN']) ? $result['response']['IntegracionCUN'] : null;
							if (!is_null($res)) {
						?>
							<tr>
								<?php $tp = $res['tipoQuejaSic'];?>
								<td> 
									<span class="text-center">
										<?php echo $tp['codtipoQuejaSic']; ?>
									</span><br>
									<?php echo $tp['nomtipoQuejaSic']; ?>
								</td>
   
								<?php $nrc = $res['numRadicadoCun'];?>
								<td> 
									<?php echo $nrc['anoRadicacionCun'];?> 
								</td>
								<td> 
									<?php echo $nrc['numRadicacionCun'];?>
								</td>
								<td> 
									<?php echo $nrc['controlRadicadoCun'];?>
								</td>
								<td> 
									<?php echo $nrc['consecutivoRadicacion'];?>
								</td>

								<?php $cun = $res['codigoUnicoNumerico'];?>
								<td> 
									<?php echo $cun['identificadorOperador']; ?>
								</td>
								<td> 
									<?php echo $cun['anoRadicacionCun']; ?>
								</td>
								<td> 
									<?php echo $cun['ConsecutivoRadCun']; ?>
								</td>
								<td>
									<?php echo date("F j, Y, g:i a", strtotime($res['fechaAsignacion'])); ?>
								</td>
			            		<td>
			            			<?php echo date("F j, Y, g:i a", strtotime($res['fechaEstRespuesta'])); ?>
			            		</td>
								<?php $np = $res['nomPersona'];?>
								<td> 
									<?php echo $np['primerApellido']; ?> 
									<?php echo $np['segundoApellido']; ?>
								</td>
								<td>
									<?php echo $np['primerNombre']; ?> 
									<?php echo $np['segundoNombre']; ?>
								</td>

								<?php $tid = $res['tipoIdNacionalPersona'];?>
								<td> 
									<?php echo $tid['codTipoIdNacionalPersona']; ?>
								</td>
								<td> 
									<?php echo $tid['nomTipoIdentificacionNacionalPersona']; ?>
								</td>
			               		<th>
			               			<?php echo $res['grupoNumeroIdentificacion']; ?>
			               		</th>
					            <th>
					            	<a href="<?php echo $res['url']; ?>" class="btn btn-link" target="__blank"> ver </a>
					            </th>
					            <th>
					            	<?php echo $res['nomOperador']; ?>
					            </th>
					            <th>
					            	<?php echo $res['descripcionEstado']; ?>
					            </th>
							</tr>
						<?php 
							}else{
								echo "<tr> <td colspan='18'> No se encontraron resultados para la consulta </td></tr>";
							}
						?>
					</tbody>
				</table>
			</div>
		</div>

	<?php } ?>
</div>
