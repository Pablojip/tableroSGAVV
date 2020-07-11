<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>SISTEMA</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href='http://fonts.googleapis.com/css?family=Raleway:400,600' rel='stylesheet' type='text/css'>
  <style type="text/css">
    
    html{
        width: 100%; 
    }

	body{
        width: 100%;  
        margin:0; 
        padding:0; 
        -webkit-font-smoothing: antialiased; 
        mso-padding-alt: 0px 0px 0px 0px;
        background: #ffffff;
    }
    
    p,h1,h2,h3,h4{
        margin-top:0;
		margin-bottom:0;
		padding-top:0;
		padding-bottom:0;
    }
    
    table{
        font-size: 14px;
        border: 0;
    }

    img{
    	border: none!important;
    }

  </style>
</head>
<body style="margin: 0; padding: 0;">

	<!--  Header  -->
	<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="#f98550" background="{{ asset('assets/img/_ofices.jpg') }}" style="height:450px; background-image: url('{{ asset('assets/img/_ofices.jpg') }}'); background-size: cover; -webkit-background-size: cover; -moz-background-size: cover -o-background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;">
	  <tr>
	   <td>

		   	<table width="90%" cellpadding="0" cellspacing="0" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		   		<tbody>
		   			<tr>
		   				<td width="100%" height="40"></td>
		   			</tr>
		   			<tr>
		   				<td>
		   					<!--  Logo  -->
		   					<table border="0" align="left" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		   						<tbody>
		   							<tr>
		   								<td>
		   									<a href="{{ route('home') }}"><img src="{{ asset('assets/img/logo_white2x.png') }}"  alt="SGAVYV" border="0" style="display: block;width: 70px"/> </a>
		   								</td>
		   							</tr>
		   						</tbody>
		   					</table>

		   					<!--  navigation menu  -->
		   					<!--<table border="0" align="right" cellpadding="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		   						<tbody>
		   							<tr>
		   								<td height="8"></td>
		   							</tr>

		   							<tr>
		   								<td style="color: #fff; font-family: 'Raleway', arial; font-weight:600; font-size: 14px; letter-spacing:0.5px;">
	   										<a href="#" style="color: #fff; text-decoration:none;">Pagina Oficial</a>
	   										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   										<a href="#" style="color: #fff; text-decoration:none;">Contacto</a>
	   										&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   										<a href="#" style="color: #fff; text-decoration:none;">Ayuda</a>
		   							</tr>
		   						</tbody>
		   					</table>-->

		   				</td>
		   			</tr>
		   			<tr>
		   				<td height="50"></td>
		   			</tr>
		   			<tr>
		   				<td style="text-align:center; color: #fff; font-family: 'Raleway', arial; font-weight:600; font-size: 30px; text-transform:uppercase; letter-spacing:3px;">SISTEMA DE GESTIÓN Y ADMINISTRACIÓN</td>
		   			</tr>
		   			<tr>
		   				<td height="50"></td>
		   			</tr>
		   			<tr>
		   				<td>
		   					<table width="24" align="center" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		   						<tr>
		   							<td><img  width="24" height="63" src="{{ asset('assets/img/down.png') }}" alt="Scroll Down" border="0" style="display:block;"/></td>
		   						</tr>
		   					</table>
		   				</td>
		   			</tr>
		   		</tbody>
		   	</table>

	   </td>
	  </tr>
	 </table>

<!--  Testimonials  -->
	@yield('content')

	<!--  footer  -->
	<table width="100%" bgcolor="#f9823a" cellpadding="0" border="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
		<tbody>
			<tr>
				<td>
					<table width="90%" align="center" cellpadding="0" border="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
						<tbody>
							<tr>
								<td width="100%" height="40px"></td>
							</tr>
							<tr>
								<td>
									<!--  footer logo  -->
									<table  align="left" cellpadding="0" border="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
										<tbody>
											<tr>
												<td><img src="{{ asset('assets/img/logo_white2x.png') }}" alt="" border="0" style="width: 50px"/></td>
												<td width="20"></td>
												<td>
													<table cellpadding="0" border="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
														<tr>
															<td width="100%" height="16"></td>
														</tr>
														<tr>
															<td style="color: #fff; font-family: 'Raleway'; font-size: 12px;">© Todos los derechos reservados.</td>
														</tr>
													</table>
												</td>
											</tr>
										</tbody>
									</table>

									<!--  footer social media  -->
									<!--<table align="right" cellpadding="0" border="0" cellspacing="0" style="border-collapse:collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;">
										<tbody>
											<tr>
												<td width="100%" height="8"></td>
											</tr>
											<tr>
												<td>
													<a href="#"><img src="TemplateEmail/Email/img/facebook.png" alt="facebook" border="0"/></a>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<a href="#"><img src="TemplateEmail/Email/img/twitter.png" alt="twitter" border="0"/></a>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<a href="#"><img src="TemplateEmail/Email/img/google+.png" alt="google+" border="0"/></a>
												</td>
											</tr>
										</tbody>
									</table>-->
								</td>
							</tr>
							<tr>
								<td width="100%" height="40px"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>

</body>
</html>