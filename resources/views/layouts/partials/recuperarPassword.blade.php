@extends('layouts.emailTemplate')

@section('content')
<table width="100%" cellpadding="0" cellspacing="0" border="0" bgcolor="#f9f9f9" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		<tbody>
			<tr>
				<td>
					<table width="80%" align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
						<tbody>
							<tr>
								<td width="100%" height="100"></td>
							</tr>
							<tr>
								<td>
									<!--  testimonial icon  -->
				   					<table width="44" align="left" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
				   						<tr>
				   							<td><img  width="20" height="20" src="{{ asset('assets/img/engranaje.png') }}"  border="0" style="display:block;"/></td>
				   						</tr>
				   					</table>
				   					<h1 style="color: #545454; font-family: 'Raleway', arial; font-weight:600; font-size: 20px; text-transform:uppercase;">Soporte y atención de SGA.</h1>
				   				</td>
							</tr>
							<tr>
								<td width="100%" height="20"></td>
							</tr>
							<tr>
								<!--  testimonial  -->
								<td align="left" style="color: #8a8a8a; font-family: 'Raleway', arial; font-size: 18px; line-height:28px; text-align:justify;">
									Estimado {{ $nombreCompleto }}:
									<p>Recibimos una solicitud para restablecer tu contraseña de SGA.</p>
									<br/>
									<a style="text-align: center;" href="{{ $url }}"><strong>Enlace | Haz clic aquí para cambiar tu contraseña</strong> </a>
									<br/>
									<br/>
									<br/>
									<p><strong>¿No solicitaste este cambio?</strong></p>
									<p>Si no solicitaste una nueva contraseña, infórmanos, para cancelar la solicitud en el siguiente enlace: </p>
									<a style="text-align: center;" href="{{ $urlCancelacion }}"><strong>Enlace | para cancelar la solicitud.</strong> </a>
									<br/>
									<br/>
									<br/>
									Atentamente.
									<br/>
									<strong>Equipo de soporte de SGA</strong>

								</td>
							</tr>
							<tr>
								<td width="100%" height="100"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
@endsection