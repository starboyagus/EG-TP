#Integrantes: Agustín Dana, Ignacio Frias, Martiniano Correa, Julieta Herrera.
cont=0
login=False
import pickle
import os
import os.path
import datetime
from datetime import datetime as dt
import stdiomask
global RegU,TmaxUs,AlUsuario,AlLocales,RegRu,TmaxLo,RegLo,CR,AfUsuario
LOC=0
class c:
    cyan = '\033[96m'
    cyano = '\033[36m'
    verde = '\033[92m'
    amarillo = '\033[93m'
    rojo = '\033[91m'
    resetear = '\033[0m'
    bold = '\033[1m'

def pausecls():
	os.system("pause")
	os.system("cls")
tipo=str("")
#creación del registro de rubro
class rubro:
    def __init__(self):
        self.tipoRubro=""
        self.cRubro=0
RegRu=rubro()
CR=[[RegRu],[RegRu],[RegRu]]
RegRu.tipoRubro="perfumeria"
RegRu.cRubro=0
CR[0]=RegRu
RegRu1=rubro()
RegRu1.tipoRubro="indumentaria"
RegRu1.cRubro=0
CR[1]=RegRu1
RegRu2=rubro()
RegRu2.tipoRubro="comida"
RegRu2.cRubro=0
CR[2]=RegRu2

#Creacion del registro de promociones
class promociones:
	def __init__(self):
		self.codPromo=0
		self.textoPromo=" "        #200 str
		self.fechaDesdePromo=dt(1,1,1)      
		self.fechaHastaPromo=dt(1,1,1)     
		self.diasSemana=[0]*7 
		self.estado=" "              #(‘pendiente’, ‘aprobada’, ‘rechazada’) 10 str
		self.codLocal=0

AfPromociones="C:\\tp3\\promociones.dat"
if not os.path.exists(AfPromociones):
	AlPromociones=open(AfPromociones,"w+b")
	
else:
	AlPromociones=open(AfPromociones,"r+b")
TmaxPro=os.path.getsize(AfPromociones)
RegPro=promociones()

#Creación del registro de locales
class locales:
	def __init__(self):
		self.nombre=" "
		self.ubicacion=" "
		self.rubro=" "
		self.codUsuario=0
		self.codLocal=0
		self.estado="A"

AfLocales="C:\\tp3\\locales.dat"
if not os.path.exists(AfLocales):
	AlLocales=open(AfLocales,"w+b")
else:
	AlLocales=open(AfLocales,"r+b")
TmaxLo=os.path.getsize(AfLocales)
RegLo=locales()
#creación del registro de usuarios
class Usuario:
	def __init__(self):
		self.cod=0
		self.usuario=""
		self.clave=""
		self.tipoUsuario=""
RegU=Usuario()
#verificamos si esta creado ya, en caso de que no este creado lo creamos y le introducimos el usuario de ADMINISTRADOR	
AfUsuario="C:\\tp3\\usuarios.dat"
if not os.path.exists(AfUsuario):
	AlUsuario=open(AfUsuario,"w+b")
	#Al tener el archivo recién creado llevamos a cabo la carga del usuario de administrador
	AlUsuario.seek(0)
	RegU.cod="1".ljust(2)
	RegU.usuario="admin@shopping.com".ljust(100)
	RegU.clave="12345".ljust(8)
	RegU.tipoUsuario="administrador".ljust(13)
	pickle.dump(RegU,AlUsuario)
	AlUsuario.flush()
else:
	AlUsuario=open(AfUsuario,"r+b")
TmaxUs=os.path.getsize(AfUsuario)
class uso_promociones:
	def __init__(self):
		self.codCliente=0
		self.codPromo=0
		self.fechaUsoPromo=dt(1,1,1)
		
AfUso_promociones="C:\\tp3\\uso_promociones.dat"
if not os.path.exists(AfUso_promociones):
	AlUso_promociones=open(AfUso_promociones,"w+b")
else:
	AlUso_promociones=open(AfUso_promociones,"r+b")
TmaxUPro=os.path.getsize(AfUso_promociones)
RegUPro=uso_promociones()
def BuscarUsuario(usIng):
	global RegU,TmaxUs,AlUsuario
	TmaxUs=os.path.getsize(AfUsuario)
	AlUsuario.seek(0)
	pos=AlUsuario.tell()
	flag=False
	while AlUsuario.tell()<TmaxUs and flag==False :
		pos=AlUsuario.tell()
		RegU=pickle.load(AlUsuario)
		if RegU.usuario==usIng:
			flag=True
	if flag==False:
		pos=-1
	return pos
def credenciales(usIng):
	global RegU,AlUsuario
	pos=BuscarUsuario(usIng)
	c=""
	if pos !=-1:
		AlUsuario.seek(pos)
		RegU=pickle.load(AlUsuario)
		
		if RegU.tipoUsuario == "administrador":
			c="administrador"
		if RegU.tipoUsuario == "dueño        ":
			c="dueño"
		if RegU.tipoUsuario == "cliente      ":
			c="cliente"
	return c

#Def utilizado para validar respuestas enteras en un intervalo
def val_ent(min,max):
	num=input("Ingrese un número dentro del rango deseado: ")
	F=True
	while F:
		try:
			num=int(num)
			if num>=min and num<=max:
				F=False
			else:
				F=True
				print("ERROR. No ingresaste un número válido. Vuelva a intentar")
				num=input("Ingrese un número dentro del rango deseado: ")
		except:
			print("ERROR. No ingresaste un número válido. Vuelva a intentar")
			num=input("Ingrese un número dentro del rango deseado: ")
	x=int(num)
	return x
def valFechaDesde():
	fecha=input()
	fecha_actual=dt.today()
	fecha_actual = fecha_actual.replace(hour=0, minute=0, second=0)
	F=True
	while F:
		try:
			fecha=dt.strptime(fecha,"%Y-%m-%d")
			fecha = fecha.replace(hour=0, minute=0, second=1)
			if fecha>=fecha_actual or fecha==fecha_actual:
				F=False
			else:
				F=True
				print("ERROR. La fecha ingresada no es válida. Intentelo nuevamente: ")
				fecha=input()
		except ValueError:
			print("ERROR. El formato de fecha ingresado no es válido.Intentelo nuevamente: ")
			fecha=input()
	return fecha
def valFechaDesdePrimate():
	fecha=input()
	fecha_primal=dt(1,1,1)
	fecha_primal = fecha_primal.replace(hour=0, minute=0, second=0)
	F=True
	while F:
		try:
			fecha=dt.strptime(fecha,"%Y-%m-%d")
			fecha = fecha.replace(hour=0, minute=0, second=1)
			if fecha>=fecha_primal or fecha==fecha_primal:
				F=False
			else:
				F=True
				print("ERROR. La fecha ingresada no es válida. Intentelo nuevamente: ")
				fecha=input()
		except ValueError:
			print("ERROR. El formato de fecha ingresado no es válido.Intentelo nuevamente: ")
			fecha=input()
	return fecha
def valFechaHasta(fechaDesde):
	fechaHasta=input()
	F=True
	while F:
		try:
			fechaHasta=dt.strptime(fechaHasta,"%Y-%m-%d")
			fechaHasta=fechaHasta.replace(hour=0, minute=0, second=0)
			if fechaHasta>fechaDesde:
				F=False
			else:
				F=True
				print("ERROR. La fecha hasta ingresada no es válida, debe ser mayor a la fecha desde ingresada.Intentelo nuevamente:")
				fechaHasta=input()
		except ValueError:
			print("ERROR. El formato de fecha ingresado no es válido.Intentelo nuevamente:")
			fechaHasta=input()
	return fechaHasta

def val_fecha(fechaDesde:dt,fechaHasta:dt):
	fecha_actual=dt.now()
	
	if (fechaDesde<fecha_actual or fechaDesde==fecha_actual) and fechaHasta>=fecha_actual:
		R=True
	else:
		R=False
	return R
def CodlocalParaPromocion(codUsuario,codIngLocal):
	global AlLocales,RegLo,AfLocales
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	F=False
	pos=-1
	while AlLocales.tell()<TmaxLo and F==False:
		pos=AlLocales.tell()
		RegLo=pickle.load(AlLocales)
		cod=int((RegLo.codUsuario).rstrip())
		codlocal=int((RegLo.codLocal).rstrip())
		if cod==codUsuario and codlocal==codIngLocal and RegLo.estado=="A":
			F=True
			pos=codlocal
			print("Local encontrado con éxito:",(RegLo.nombre).rstrip())
	if F==False:
		pos=-1
	return pos
def traerCodPromo():
	global AlPromociones,RegPro
	TmaxPro=os.path.getsize(AfPromociones)
	AlPromociones.seek(0)
	cMayor=0
	while AlPromociones.tell()<TmaxPro:
		RegPro=pickle.load(AlPromociones)
		cod=int((RegPro.codPromo).rstrip())
		if cod>cMayor:
			cMayor=cod
	return cMayor
def formatUs(x:Usuario):
	x.cod=str(x.cod).ljust(2)
	x.usuario=(x.usuario).ljust(100)
	x.clave=(x.clave).ljust(8)
	x.tipoUsuario=(x.tipoUsuario).ljust(13)
	return x
def formatLo(x:locales):
	x.nombre=(x.nombre).ljust(50)
	x.ubicacion=(x.ubicacion).ljust(50)
	x.rubro=(x.rubro).ljust(50)
	x.codUsuario=str(x.codUsuario).ljust(2)
	x.codLocal=str(x.codLocal).ljust(2)
	x.estado=(x.estado).ljust(1)
	return x
def formatPro(x:promociones):
	x.codPromo=str(x.codPromo)
	x.codPromo=(x.codPromo).ljust(2)
	x.textoPromo=(x.textoPromo).ljust(200)     #200 str     
	x.estado=(x.estado).ljust(10)         #(‘pendiente’, ‘aprobada’, ‘rechazada’) 10 str
	x.codLocal=str(x.codLocal).ljust(2)
	x.codLocal=str(x.codLocal).ljust(2)
	return x
def formatUsoPro(x:uso_promociones):
	x.codCliente=str(x.codCliente).ljust(2)
	x.codPromo=str(x.codPromo).ljust(2)
	return x
# Función para crear un descuento
def crearDescuento(usIng):
	global RegPro,AlPromociones,AlUsuario,RegU
	diasSemana=[[0],[0],[0],[0],[0],[0],[0]]
	pos=BuscarUsuario(usIng)
	AlUsuario.seek(pos)
	RegU=pickle.load(AlUsuario)
	codUsuario=int(RegU.cod.rstrip())
	listardescuentos(usIng)
	pausecls()
	print("Ingrese el codigo del local al que desea agregar una promoción (0 para volver atrás)")
	cMax=traerCodLocal()
	codLocalIng=val_ent(0,cMax)
	os.system("cls")
	code=CodlocalParaPromocion(codUsuario,codLocalIng)
	maxPromo=traerCodPromo()
	if codLocalIng!=0:
		if code != -1:
			print("Ingrese el texto de la promoción: ")
			texto=input()
			os.system("cls")
			while len(texto)>200:        
				print("Ha superado el límite de caracteres (200), intente con algo más corto...")
				texto=str(input())
			texto=texto.ljust(200).lower()
			print("Ingrese la fecha de inicio de la promoción (YYYY-MM-DD): ")
			fecha_desde=valFechaDesde()
			print("Fecha de Inicio ingresada: ",fecha_desde)
			print("Ingrese la fecha de fin de la promoción (YYYY-MM-DD): ")
			fecha_hasta=valFechaHasta(fecha_desde)
			print("Fecha de Fin ingresada: ",fecha_hasta)
			for i in range(7):
				os.system("cls")
				if i==0:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Domingo")
					diasSemana[i] = val_ent(0,1)
				if i==1:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Lunes")
					diasSemana[i] = val_ent(0,1)
				if i==2:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Martes")
					diasSemana[i] = val_ent(0,1)
				if i==3:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Miércoles")
					diasSemana[i] = val_ent(0,1)
				if i==4:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Jueves")
					diasSemana[i] = val_ent(0,1)
				if i==5:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Viernes")
					diasSemana[i] = val_ent(0,1)
				if i==6:
					print("Ingrese los días de la semana en que estará disponible la oferta (0 para no válido, 1 para válido):")
					print("Sábado")
					diasSemana[i]=val_ent(0,1)
			AlPromociones.seek(0,2)
			if maxPromo==0:
				AlPromociones.seek(0)
				RegPro.codPromo=maxPromo+1
			else:
				RegPro.codPromo=maxPromo+1
			RegPro.textoPromo=texto
			RegPro.fechaDesdePromo=fecha_desde    
			RegPro.fechaHastaPromo=fecha_hasta
			for i in range(7):     
				RegPro.diasSemana[i]=diasSemana[i]
			RegPro.estado="pendiente".ljust(10)             
			RegPro.codLocal=code
			RegPro=formatPro(RegPro)
			pickle.dump(RegPro,AlPromociones)
			AlPromociones.flush()
		else:
			print("Código de local inválido...")
			print("Volverá al menú anterior.")
		os.system("pause")
		os.system("cls")
	else:
		os.system("cls")
#Función para listar descuentos disponibles
def listardescuentos(usIng):
	os.system("cls")
	global RegPro,RegU,AlPromociones,AlUsuario,AfPromociones,AlLocales,RegLo,AfLocales
	TmaxPro=os.path.getsize(AfPromociones)
	if TmaxPro!=0:
		AlPromociones.seek(0)
		RegPro = pickle.load(AlPromociones)
		pos=BuscarUsuario(usIng)
		AlUsuario.seek(pos)
		RegU=pickle.load(AlUsuario)
		codUs=RegU.cod
		AlLocales.seek(0)
		TmaxLo=os.path.getsize(AfLocales)
		#Hacer función que compruebe que codLocal de PROMOCIONES se corresponda con el codLocal del archivo LOCALES.DAT, y estos locales tengan como codUsuario al dueño de local logueado y su estado de local sea ’A’
		while AlLocales.tell()<TmaxLo:
			RegLo=pickle.load(AlLocales)
			if RegLo.codUsuario==codUs and RegLo.estado=="A":
				AlPromociones.seek(0)
				while AlPromociones.tell()<TmaxPro:
					RegPro=pickle.load(AlPromociones)
					fechaVigente=val_fecha(RegPro.fechaDesdePromo,RegPro.fechaHastaPromo)
					if RegPro.codLocal==RegLo.codLocal and fechaVigente==True :
						print("Nombre del local: ",(RegLo.nombre).rstrip())
						print("Código de promoción",end="/")
						print("Texto de la promoción",end="/")
						print("Dias de la semana(L/M/X/J/V/S/D)")
						print("Fecha desde",end="/")
						print("Fecha hasta",end="/")
						print("Estado")
						print((RegPro.codPromo),end="/")
						print((RegPro.textoPromo).rstrip(),end="/")
						mostrarDiasSemanas(RegPro.diasSemana)
						print((RegPro.fechaDesdePromo),end="/")
						print((RegPro.fechaHastaPromo),end="/")
						if ((RegPro.estado).rstrip())=="aprobada":
							print(c.verde,"APROBADA",c.cyan)
						if ((RegPro.estado).rstrip())=="rechazada":
							print(c.rojo,"RECHAZADA",c.cyan)
						if ((RegPro.estado).rstrip())=="pendiente":
							print("pendiente")
	else:
		print("No hay promociones")
def MenuDue(usIng):
	rta=-1
	while rta!=0:
		os.system("cls")
		print("Seleccione una de las siguientes opciones")
		print("1.Crear descuento")
		print("2.Reporte de uso de descuentos")
		print("3.Ver novedades")
		print("0. Salir")
		rta=val_ent(0,3)
		if rta==1:
			os.system("cls")
			crearDescuento(usIng)       #pasarle cod usuario de dueño de local
		if rta==2:
			os.system("cls")
			reporte_uso_descuentos(usIng)
			os.system("pause")
		if rta==3:
			os.system("cls")
			print("Punto desarollado en chapin")
			os.system("pause")
		os.system("cls")
def reporte_uso_descuentos(usuarioLogueado):
	global AlPromociones,RegPro,AfPromociones,AlLocales,RegLo,AfLocales,AlUso_promociones,RegUPro,AfUso_promociones
	TMaxUsoPromociones=os.path.getsize(AfUso_promociones)
	if TMaxUsoPromociones!=0:
		print("Ingrese la fecha desde la cual querrá ver las promociones disponibles")
		fecha_desde=valFechaDesdePrimate()
		print("Ingrese la fecha hasta la cual querrá ver las promociones disponibles")
		fecha_hasta=valFechaHasta(fecha_desde)
		TMaximoPromociones=os.path.getsize(AfPromociones)
		lugarUsuarioLogueado=BuscarUsuario(usuarioLogueado)
		AlUsuario.seek(lugarUsuarioLogueado)
		RegU=pickle.load(AlUsuario)
		codigoUsuarioIng=RegU.cod
		AlLocales.seek(0)
		TmaxLo=os.path.getsize(AfLocales)
		os.system("cls")
		print("--------------INFORME DE USO DE DECUENTOS-------------------")
		print("fecha desde:",fecha_desde,"             fecha hasta:",fecha_hasta)
		while AlLocales.tell()<TmaxLo:
			contLocal=0 #contador para saber si exhibir nuevamente o no la info del local, para no exhibirlo cada vez que muestro la info de las promos 
			RegLo=pickle.load(AlLocales)
			AlPromociones.seek(0)
			while AlPromociones.tell()<TMaximoPromociones:
				RegPro=pickle.load(AlPromociones)
				if RegLo.codUsuario==codigoUsuarioIng:
					if RegPro.codLocal==RegLo.codLocal and ((RegPro.estado).rstrip())=="aprobada" and RegPro.fechaDesdePromo>=fecha_desde and RegPro.fechaHastaPromo<=fecha_hasta:
						AlUso_promociones.seek(0)
						print("------------------------------------------------------------")
						c=0
						while AlUso_promociones.tell()<TMaxUsoPromociones:
							RegUPro=pickle.load(AlUso_promociones)
							if RegUPro.codPromo==RegPro.codPromo and RegPro.fechaDesdePromo<=RegUPro.fechaUsoPromo and RegPro.fechaHastaPromo>=RegUPro.fechaUsoPromo:
								c=c+1
						if contLocal==0:
							print("Local nro ",RegLo.codLocal,"---Nombre:",RegLo.nombre)
							print("CÓDIGO PROMO/   TEXTO   /FECHA DESDE/FECHA HASTA/ CANT. USOS")
							print("------------------------------------------------------------")
						contLocal=contLocal+1
						print(RegPro.codPromo,end="/")
						print((RegPro.textoPromo).rstrip(),end="/")
						print(RegPro.fechaDesdePromo,end="/")
						print(RegPro.fechaHastaPromo,end="/")
						print("   ",c)
	else:
		print("No se registraron usos de promociones")
def Largo50(palabra):
	while len(palabra)>50:
		print("Ha superado el límite de caracteres (50), intente con algo más corto")
		palabra=(str(input()))
	return palabra
def Largo100(palabra):
	while len(palabra)>100 or palabra==" " or palabra=="":
		print("Ha superado el límite de caracteres (100), intente con algo más corto")
		palabra=(str(input()))
	return palabra
def Largo8(palabra):
	while len(palabra)!=8:
		print("La longitud de la clave debe ser de 8 caracteres")
		palabra=stdiomask.getpass()
	return palabra
def BusqDesc():
	print("Ingrese un codigo de local: ")
	max=traerCodLocal()
	codLocal=val_ent(1,max)
	if BuscarCod(codLocal)==-1:
		while BuscarCod(codLocal)==-1:
			print("ese código no existe, intente con otro")
			codLocal=val_ent(1,max)
	else:
		print()

def MenuCliente(usIng):
	global AlUsuario,RegU
	pos=BuscarUsuario(usIng)
	AlUsuario.seek(pos)
	RegU=pickle.load(AlUsuario)
	codUsuario=RegU.cod
	Rta=-1
	while Rta!=0:
		os.system("cls")
		print("1. Buscar descuentos en local")
		print("2. Solicitar descuento")
		print("3. Ver novedades")
		print("0. Salir")
		Rta=val_ent(0,3)
		if Rta==1:
			os.system("cls")
			buscarDescuentos()
		if Rta==2:
			os.system("cls")
			solicitarDescuentos(codUsuario)
			os.system("pause")
		if Rta==3:
			os.system("cls")
			print("Solo diagramado en chapín")
			os.system("pause")
			os.system("cls")
	os.system("cls")
def buscarDescuentos():
	global AfPromociones,RegPro,AlPromociones,AlLocales,RegLo,AfLocales
	AlPromociones.seek(0)
	RegPro=pickle.load(AlPromociones)
	codLocalMax=traerCodLocal()
	if os.path.getsize(AfPromociones)!=0:
		print("Ingrese el código del local para el cual quiere buscar promociones (0 para salir)")
		codLocalIng=val_ent(0,codLocalMax)
		if codLocalIng!=0:
			print("Ingrese la fecha en la que quiere buscar promoción (yyyy-mm-dd)")
			fechaIng=valFechaDesde()
			AlPromociones.seek(0)
			TmaxPro=os.path.getsize(AfPromociones)
			C=0
			while AlPromociones.tell()<TmaxPro:
				RegPro=pickle.load(AlPromociones)
				if int(RegPro.codLocal)==codLocalIng and verificarPromo(RegPro,fechaIng)==True:
					print("Código de la promo/    Texto     /Fecha Desde/Fecha Hasta")
					print((RegPro.codPromo).rstrip(),end="/")
					print((RegPro.textoPromo).rstrip(),end="/")
					print(RegPro.fechaDesdePromo,end="/")
					print(RegPro.fechaHastaPromo)
					os.system("pause")
					C=C+1
			if C==0: 
				print("No se encontraron descuentos disponible en la fecha ingresada")
				
			pausecls()				
	else:
		print("No hay promociones")
def verificarPromo(RegPro:promociones, fecha:dt):
	if fecha>=RegPro.fechaDesdePromo and RegPro.fechaHastaPromo>=fecha:
		fecha_vigente=True
	else:
		fecha_vigente=False
	estado=(RegPro.estado).rstrip()
	if fecha_vigente==True and estado=="aprobada":
		os.system("pause")
		diaIngresado=fecha.weekday()
		if diaIngresado!=6:
			diaIngresado=diaIngresado+1
		else:
			diaIngresado=0
		if RegPro.diasSemana[diaIngresado]==1:
			Bandera=True
		else:
			print(RegPro.diasSemana[diaIngresado])
			Bandera=False
		return Bandera

def solicitarDescuentos(codUsuario):
	global AlPromociones,AfPromociones,RegPro,AlUso_promociones,RegUPro
	codMaxPro=traerCodPromo()
	os.system("cls")
	c=0
	print("Ingrese el código de una promoción (0 para salir)")
	codPIng=val_ent(0,codMaxPro)
	if codPIng!=0:
		AlPromociones.seek(0)
		TMax=os.path.getsize(AfPromociones)
		if TMax!=0:
			c=0
			while AlPromociones.tell()<TMax:
				RegPro=pickle.load(AlPromociones)
				fechaHoy=dt.now()
				if verificarPromo(RegPro,fechaHoy) and codPIng==int(RegPro.codPromo):
					c=c+1
					x=RegPro
					AlUso_promociones.seek(0,2)
					RegUPro.codCliente=codUsuario
					RegUPro.codPromo=codPIng
					RegUPro.fechaUsoPromo=fechaHoy
					RegUPro=formatUsoPro(RegUPro)
					pickle.dump(RegUPro,AlUso_promociones)
					AlUso_promociones.flush()
					print("Uso de promoción registrado con éxito.",RegPro.textoPromo)
				
			if c== 0 :
				print("No hay promociones que puedan utilizarse hoy")		
		else:
			print("No hay promociones cargadas")		
def ValidarCodUsuario(entrada):
	global RegU,TmaxUs,AlUsuario
	TmaxUs=os.path.getsize(AfUsuario)
	AlUsuario.seek(0)
	pos=AlUsuario.tell()
	flag=False
	while AlUsuario.tell()<TmaxUs and flag==False :
		pos=AlUsuario.tell()
		RegU=pickle.load(AlUsuario)
		if int(RegU.cod)==entrada and RegU.tipoUsuario=="dueño        ":
			flag=True
	if flag==False:
		pos=-1
	return pos

def ValidarRubro(entrada):
	while entrada!= "indumentaria" and entrada!= "perfumeria" and entrada!="comida":
			print("Por favor ingrese un rubro existente.")
			entrada=str(input())
			entrada=entrada.lower()
	return entrada

def OrdenaRubro():
    global CR,RegRu
    for i in range(2):
        for j in range(i,3):
            RegRu=CR[i]
            c1=RegRu.cRubro
            RegRu=CR[j]
            c2=RegRu.cRubro
            if c1 < c2:
                RegRu=CR[i]
                CR[i]=CR[j]
                CR[j]=RegRu
#def para mostrar la cantidad de locales por rubro
def MuestraRubro():
	global CR,RegRu
	for i in range(3):
		RegRu=CR[i]
		print(RegRu.tipoRubro,end=": ")
		print(RegRu.cRubro)
#def para ordenar todo alfabeticamente por el nombre
def ordenLocales():
	global AlLocales,RegLo
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	aux=locales()
	aux2=locales()
	aux=pickle.load(AlLocales)
	TamReg=AlLocales.tell()
	cantReg=TmaxLo//TamReg
	for i in range(0,cantReg-1):
		for j in range(i+1,cantReg):
			AlLocales.seek(i*TamReg,0)
			aux=pickle.load(AlLocales)
			AlLocales.seek(j*TamReg,0)
			aux2=pickle.load(AlLocales)
			if aux.nombre > aux2.nombre:
				AlLocales.seek(i*TamReg,0)
				pickle.dump(aux2,AlLocales)
				AlLocales.seek(j*TamReg,0)
				pickle.dump(aux,AlLocales)
				AlLocales.flush()
	
#def para verificar con busqueda dicotómica que el nombre asignado al local no esta en uso
def validarNombre(nomIng):
	global TmaxLo,AlLocales,RegLo,AfLocales
	TmaxLo=os.path.getsize(AfLocales)
	if TmaxLo==0:
		pos=-1
	else:
		AlLocales.seek(0)
		RegLo=pickle.load(AlLocales)
		TamReg=AlLocales.tell()
		CantReg=TmaxLo//TamReg
		q=False
		com=0
		fin=CantReg-1
		M=(fin+com)//2
		AlLocales.seek(M*TamReg,0)
		RegLo=pickle.load(AlLocales)
		if RegLo.nombre==nomIng:
			pos=M*TamReg
		else:
			while fin>com and q==False and AlLocales.tell()<TmaxLo:
				M=(com+fin)//2
				pos=M*TamReg
				AlLocales.seek(pos,0)
				RegLo=pickle.load(AlLocales)
				if RegLo.nombre==nomIng:
					q=True
					print(q)
				else:
					if RegLo.nombre<nomIng:
						com=M+1
					else:
						fin=M-1
			if nomIng!=RegLo.nombre:
				pos=-1
	return pos
def pasarEntero(x:str):
	entero=int(x)
	return entero
def traerCodLocal():
	global AlLocales,RegLo,AfLocales
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	cMayor=0
	while AlLocales.tell()<TmaxLo:
		cod=int(RegLo.codLocal)
		RegLo=pickle.load(AlLocales)
		if cod>cMayor:
			cMayor=cod
	return cMayor

def mostrarUsuarios():
	print("Estos son los usuarios hasta el momento:")
	print("-------------------------------------------")
	print("[Usuario/Clave/Código de Usuario/Tipo de Usuario]")
	print("-------------------------------------------")
	global AlUsuario,AfUsuario
	AlUsuario.seek(0)
	TmaxUs=os.path.getsize(AfUsuario)
	while AlUsuario.tell()<TmaxUs:
		RegU=pickle.load(AlUsuario)
		print((RegU.usuario).rstrip(),end="/")
		print((RegU.clave).rstrip(),end="/")
		print((RegU.cod).rstrip(),end="/")
		print((RegU.tipoUsuario).rstrip())
	print("-------------------------------------------")

def inglocales(tope):
	global RegU,RegLo,TmaxLo,AlLocales,AlUsuario,AfUsuario
	TmaxUs=os.path.getsize(AfUsuario)
	codMaxUsuario=traerCmaxUsuario()
	codLocal=traerCodLocal()        
	mostrarUsuarios()
	pausecls()
	co=0
	print("Ingrese el nombre del local o la letra 'N' en caso de querer dejar de ingresar locales:")
	nombre=input()
	nombre=Largo50(nombre).ljust(50).lower()
	salida="n".ljust(50)
	os.system("cls")
	while co<tope and nombre!=salida:
		if validarNombre(nombre)==-1 :				
			print("Ingrese la ubicación del local: ")
			ubiLo=input()
			ubiLo=Largo50(ubiLo)
			os.system("cls")
			print("Ingrese el código del usuario:")
			codUs=val_ent(0,codMaxUsuario)
			busCod=ValidarCodUsuario(codUs)
			if busCod==-1:
				while busCod==-1:
					print("ese código no existe o no pertenece a un usuario del tipo dueño, intente con otro")
					codUs=val_ent(0,codMaxUsuario)
					busCod=ValidarCodUsuario(codUs)
			os.system("cls")
			print("Ingrese el rubro del local: (indumentaria, perfumeria o comida)")
			rubro=input().lower()
			rubro=Largo50(rubro)
			rubro=ValidarRubro(rubro) 
			AlLocales.seek(0,2)
			codLocal=codLocal+1 
			RegLo.nombre=nombre.ljust(50)
			RegLo.ubicacion=ubiLo.ljust(50)
			RegLo.rubro=rubro.ljust(50)
			RegLo.estado="A"
			RegLo.codUsuario=codUs  
			RegLo.codLocal=codLocal
			co=co+1
			contRubro(rubro)
			#aumenta el array utilizado para contar la cantidad por rubro
			RegLo=formatLo(RegLo)
			pickle.dump(RegLo,AlLocales)
			AlLocales.flush()
			os.system("cls")
			ordenLocales()
			#ordena los locales para que la busqueda dicotomica sea posible
			pausecls()
		else:
			os.system("cls")
			print("Ese nombre esta ocupado, intente con otro.")
		if co!=tope:
			print("Ingrese el nombre del local o la letra 'N' en caso de querer dejar de ingresar locales:")
			nombre=input()
			nombre=Largo50(nombre).ljust(50).lower()
	#ordena alfabeticamente todos los array de acuerdo a los nombres de los locales de la A, a la Z
	os.system("cls")
	ordenLocales()
	OrdenaRubro()
	MuestraRubro()
	MuestraLocales()
	pausecls()

#def para mostrar la información de todos los locales alfabeticamente
def MuestraLocales():
	global AlLocales,RegLo
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	if TmaxLo!=0:
		print("Locales cargados:")
		print("[N° local/Nombre/Ubicación/Rubro/Código de usuario/Estado]")
		print("----------------------------------------------------------")
		while AlLocales.tell()<TmaxLo:
			RegLo=pickle.load(AlLocales)
			print((RegLo.codLocal.rstrip()),end="/")
			print((RegLo.nombre).rstrip(),end="/")
			print((RegLo.ubicacion).rstrip(),end="/")
			print((RegLo.rubro).rstrip(),end="/")
			print((RegLo.codUsuario.rstrip()),end="/")
			if RegLo.estado=="B":
				print(c.rojo+ RegLo.estado + c.cyan)
			else:
				print(c.verde+ RegLo.estado + c.cyan)
			print("----------------------------------------------------------")
	else:
		print("No hay locales cargados")
	#def para aumentar el array contador de la cantidad de locales por rubro			
def contRubro(rubro):
	rubro=rubro.rstrip()
	global CR,RegRu
	for i in range(3):
		RegRu=CR[i]
		if RegRu.tipoRubro==rubro:
			RegRu.cRubro=RegRu.cRubro + 1
			CR[i]=RegRu
	
def sesionFallida():
	os.system("cls")
	print("Usted ha agotado sus intentos de inicio de sesión")
	print("...")
	print("..")
	print(".")
def const():
	os.system("cls")
	print("En construcción")
	print("...")
	print("..")
	print(".")

def inSesion(usIng,conIng):
	global RegU,AlUsuario
	pos=BuscarUsuario(usIng)
	if pos==-1:
		os.system("cls")
		print("USUARIO INCORRECTO, INTENTELO NUEVAMENTE")
		login=False	
	else:
		AlUsuario.seek(pos,0)
		RegU=pickle.load(AlUsuario)
		if conIng!=RegU.clave:
			os.system("cls")
			print("Contraseña incorrecta. Intentelo nuevamente")
			login=False
		if conIng==RegU.clave:
			login=True
			os.system("cls")
			print(c.bold,c.cyan + "BIENVENIDO:" + c.resetear,c.cyan,RegU.tipoUsuario)
	return login 
def menu4():
	print("a. Crear novedades")
	print("b. Modificar novedad")
	print("c. Elminar novedad")
	print("d. Ver reportes de novedades")
	print("e. Salir")
	r=input()
	r=r.lower()

	return r
def menu():
	print("Seleccione una opción ingresando su respectivo número:")
	print("1. Gestión de locales")
	print("2. Crear cuentas de dueños de locales")
	print("3. Aprobar/denegar solicitud de descuento")
	print("4. Gestión de novedades")
	print("5. Reporte de utilizaciòn de descuentos")
	print("0. Salir")
	respuesta=""
	respuesta=str(input())
	os.system("cls")
	while respuesta!="1" and respuesta!="2" and respuesta!="3" and respuesta!="4" and respuesta!="5" and respuesta!="0":
		print("Por favor seleccione una opción existente")
		respuesta=menu()
	return respuesta
def opcion1():
		print("Seleccione una opción ingresando su respectiva letra.")
		print("a. Crear locales")
		print("b. Modificar locales")
		print("c. Eliminar local")
		print("d. Mapa de locales")
		print("e. Volver")
		r=str(input())
		r=r.lower()
		os.system("cls")
		if r !="a" and r!= "b" and r!= "c" and r!= "d" and r!="e": 
			print("Incorrecto. Seleccione una opción existente")		
		return r 

def opcionc():
	global AlLocales,RegLo,AfLocales
	MuestraLocales()
	if os.path.getsize(AfLocales)!=0:
		print("Ingrese el código del local que desea dar de baja:(0 para salir) ")
		max=traerCodLocal()
		codLocal=val_ent(0,max)
		if codLocal!=0:
			posi=BuscarCod(codLocal)
			AlLocales.seek(posi)
			RegLo=pickle.load(AlLocales)
			if RegLo.estado=="B":
				print("Ese local ya esta dado de baja,¿desea darle el alta?(si/no): ")
				rta=str(input()).lower()
				while rta!="si" and rta!="no":
					rta=str(input("Respuesta incorrecta, intentelo de nuevo: "))
					rta=rta.lower
					pausecls()
				if rta=="si":
					contRubro(RegLo.rubro)
					RegLo.estado="A"
					print("Se ha dado de alta el local")
					pausecls()
			else:
				print("¿Esta seguro que desea borrar el local llamado:",RegLo.nombre,"?(si/no)")
				rta=str(input()).lower()
				while rta!="si" and rta!="no":
					rta=str(input("Respuesta incorrecta, intentelo de nuevo: "))
					rta=rta.lower()
					pausecls()
				if rta=="si":
					RestarRubro(RegLo.rubro)
					RegLo.estado="B"
					print("se ha dado de baja el local")
					pausecls()
			AlLocales.seek(posi)
			RegLo=formatLo(RegLo)
			pickle.dump(RegLo,AlLocales)
			AlLocales.flush()
	else:
		os.system("cls")
		print("No podrá eliminar locales si no existen")

def opcionD():
	global AlLocales,RegLo,AfLocales
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	if TmaxLo!=0:
		RegLo=pickle.load(AlLocales)
		TamReg=AlLocales.tell()
		CantReg=TmaxLo//TamReg
		ROJO="\033[31m"
		RESET="\033[0m"
		AlLocales.seek(0)
		if CantReg>50:
			print("------------Mapa de Locales---------")
			print("")
			for i in range(10):
				print(RESET+ "+ - + - + - + - + - +")
				for k in range(5):
					if k==0:
						print("|",end="")
					if k==4:
						RegLo=pickle.load(AlLocales)
						if RegLo.estado=="B":
							print(c.rojo+"",RegLo.codLocal,""+RESET,end="")
							print("|")
						else:
							print("",RegLo.codLocal,"",end="")
							print("|")
					else:
						RegLo=pickle.load(AlLocales)
						if RegLo.estado=="B":
							print(c.rojo+"",RegLo.codLocal,""+RESET,end="|")
						else:
							print("",RegLo.codLocal,"",end="|")
			print(RESET+"PROXIMAMENTE SE HABILITARÁ UN MAPA CON LOS DEMÁS LOCALES...")
		else:
			print("------------Mapa de Locales---------")
			print("")
			AlLocales.seek(0)
			for i in range(10):
				print(RESET+ "+ - + - + - + - + - + - + -")
				for k in range(5):
					if AlLocales.tell()<TmaxLo:
						if k==0:
							print("|",end="")
						if k==4:
							RegLo=pickle.load(AlLocales)
							if RegLo.estado=="B":
								print(c.rojo+"",RegLo.codLocal,"",+RESET,end="")
								print("|")
							else:
								print("",RegLo.codLocal,"",end="")
								print("|")
						else:
							RegLo=pickle.load(AlLocales)
							if RegLo.estado=="B":
								print(c.rojo+"",RegLo.codLocal,""+RESET,end="|")
							else:
								print("",RegLo.codLocal,"",end="|")
					else:
						if k==0:
							print("|",end="")
						if k==4:
							print("","0 ","",end="")
							print("|")
						else:
							print("","0 ","",end="|")
			print(RESET+ "+ - + - + - + - + - + - + -")
			print(c.cyan+ "")
			pausecls()
	else:
		print("No hay locales cargados")
def PregLocales():
	print("¿Desea ver los locales?(si/no): ")
	R=str(input())
	R=R.lower()
	while R!="si" and R!="no":
		print("Ingrese un valor correcto: ")
		R=str(input())
		R=R.lower()
	os.system("cls")

	if R=="si":
		MuestraLocales()
def llenarRubro():
	global AlLocales,AfLocales,RegLo
	AlLocales.seek(0)
	TmaxLo=os.path.getsize(AfLocales)
	while AlLocales.tell()<TmaxLo:
		RegLo=pickle.load(AlLocales)
		contRubro(RegLo.rubro)
def menuAdmin(login):
	global LOC,AlUsuario,AfUsuario,RegLo,AlPromociones,AfPromociones,AlLocales,AfLocales,RegU
	global RegPro,AfPromociones,AlUso_promociones,RegUPro,AfUso_promociones
	respuesta=1
	while respuesta!="0" and login==True:
		respuesta=menu()
		os.system("cls")
		if respuesta=="1":
			r="a"
			while r!="e":
				r=opcion1()
				if r=="a":
					os.system("cls")
					PregLocales()
					input(("Aprete enter para continuar"))
					os.system("cls")
					AlUsuario.seek(0)
					TmaxUs=os.path.getsize(AfUsuario)
					exist=False 
					while AlUsuario.tell()<TmaxUs and exist==False:
						RegU=pickle.load(AlUsuario)
						if ((RegU.tipoUsuario).rstrip())=="dueño":
							exist=True
					if exist==True:
						print("Ingrese la cantidad de locales a crear:[1-50] ")
						cant=val_ent(1,50)
						if cant<=50:
							os.system("cls")
							inglocales(cant)	
						else:
							print("Usted ha superado el límite de carga de locales, intente con un número más bajo")
					else:
						print("No hay cuentas de tipo dueño cargadas")
						pausecls()
				if r=="b":
					os.system("cls")
					PregLocales()
					input(("Aprete enter para continuar"))
					os.system("cls")
					codMaxLocal=traerCodLocal()
					if os.path.getsize(AfLocales)!=0:
						print("Ingrese un codigo de local válido o 0 si quiere salir")
						codIng=val_ent(0,codMaxLocal)
						if codIng!=0:
							pos=BuscarCod(codIng)
							if pos==-1:
								print("Ese código de local no existe, intente con otro")
							else:
								opcionb(pos)
								MuestraRubro()
							pausecls()
					else:
						print("No hay locales cargados")
				if r=="c":
					os.system("cls")
					PregLocales()
					input(("Aprete enter para continuar"))
					os.system("cls")
					opcionc()
					MuestraLocales()
					MuestraRubro()
					pausecls()

				if r=="d":
					os.system("cls")
					PregLocales()
					input("Aprete enter para continuar")
					os.system("cls")
					opcionD()
					pausecls()

		if respuesta=="2":
			os.system("cls")
			print("Ingrese el mail con el que se asociará su cuenta:")
			nombre=input()
			nombre=Largo100(nombre)
			pos=BuscarUsuario(nombre.ljust(100))
			if pos!=-1:
				print("Ese mail ya está en uso, por favor intente con otro")
				os.system("pause")
				os.system("cls")
			else:
				print("Ingrese su clave de 8 caracteres")
				clave=stdiomask.getpass()
				clave=Largo8(clave)
				codMaxUsuario=traerCmaxUsuario()
				AlUsuario.seek(0,2)
				RegU.usuario=nombre.ljust(100)
				RegU.clave=clave.ljust(8)
				RegU.tipoUsuario="dueño".ljust(13)
				RegU.cod=codMaxUsuario+1
				RegU=formatUs(RegU)
				pickle.dump(RegU,AlUsuario)
				AlUsuario.flush()
				os.system("cls")
				print("Dueño de Local creado exitosamente.")
				os.system("pause")
				os.system("cls")

		if respuesta=="3":
			
			os.system("cls")
			TmaxPro=os.path.getsize(AfPromociones)
			AlPromociones.seek(0)
			if TmaxPro!=0:
				AlPromociones.seek(0)
				RegPro=pickle.load(AlPromociones)
				print("[Nombre del local",end="/")
				print("Código del local",end="/")
				print("Código de promoción",end="/")
				print("Texto de la promoción",end="/")
				print("Fecha desde",end="/")
				print("Fecha hasta",end="/")
				print("Dias de la semana(D/L/M/X/J/V/S)",end="/")
				print("Estado]")
				print("---------------------------------------------------------------------------------------------------------------------------------------------")
				while AlPromociones.tell()<TmaxPro:
					RegPro=pickle.load(AlPromociones)
					if ((RegPro.estado).rstrip())=="pendiente":
						AlLocales.seek(0)
						TmaxLo=os.path.getsize(AfLocales)
						f=0
						while AlLocales.tell()<TmaxLo and f==0:
							RegLo=pickle.load(AlLocales)
							if RegLo.codLocal==RegPro.codLocal:
								print((RegLo.nombre).rstrip(),end="/")
								print((RegLo.codLocal).rstrip(),end="/")
								f=-1
						print((RegPro.codPromo).rstrip(),end="/")
						print((RegPro.textoPromo).rstrip(),end="/")
						print((RegPro.fechaDesdePromo),end="/")
						print((RegPro.fechaHastaPromo),end="/")
						mostrarDiasSemanas(RegPro.diasSemana)
						print((RegPro.estado).rstrip())
						print("-------------------------------------------------------------------------------------------")
				print("Ingrese un código de promoción(0 si quiere cancelar)")
				max=pasarEntero(RegPro.codPromo)
				codPromoIng=val_ent(0,max)
				if codPromoIng!=0:
					os.system("cls")
					AlPromociones.seek(0)
					q=False
					while AlPromociones.tell()<TmaxPro and q==False:
						pos=AlPromociones.tell()
						RegPro=pickle.load(AlPromociones)
						codPromo=pasarEntero(RegPro.codPromo)
						if codPromo==codPromoIng and ((RegPro.estado).rstrip())=="pendiente":
							q=True
					if q==True and ((RegPro.estado).rstrip())=="pendiente":
						print("El código ingresado pertenece a la promoción:",RegPro.textoPromo)
						print("¿Desea aceptar(1) o rechazar(0)?")
						rta=val_ent(0,1)
						AlPromociones.seek(pos)
						if rta==1:
							RegPro.estado="aprobada".ljust(10)
						else:
							RegPro.estado="rechazada".ljust(10)
						os.system("cls")
						print("Promoción ",RegPro.estado)
						RegPro=formatPro(RegPro)
						pickle.dump(RegPro,AlPromociones)
						AlPromociones.flush()
						pausecls()
					else:
						print("El código ingresado no pertenece a una promoción con estado pendiente")
			else:
				print("El archivo esta vacío")
		if respuesta=="4":
			os.system("cls")
			print("Esta opción esta desarollada en el chapín")
			pausecls()
		if respuesta=="5":
			os.system("cls")
			TMaxUsoPromociones=os.path.getsize(AfUso_promociones)
			if TMaxUsoPromociones!=0:
				print("Ingrese las fechas a partir de la cual quiere ver las promociones")
				fecha_desde=valFechaDesdePrimate()
				print("Ingrese la fecha hasta la cual querrá ver las promociones disponibles")
				fecha_hasta=valFechaHasta(fecha_desde)
				TMaximoPromociones=os.path.getsize(AfPromociones)
				AlLocales.seek(0)
				TmaxLo=os.path.getsize(AfLocales)
				os.system("cls")
				print("------------------------------------------INFORME DE USO DE DECUENTOS-----------------------------------------------")
				print("fecha desde:",fecha_desde,"                  fecha hasta:",fecha_hasta)
				while AlLocales.tell()<TmaxLo:
					contLocal=0 #contador para saber si exhibir nuevamente o no la info del local, para no exhibirlo cada vez que muestro la info de las promos 
					RegLo=pickle.load(AlLocales)
					AlPromociones.seek(0)
					while AlPromociones.tell()<TMaximoPromociones:
						RegPro=pickle.load(AlPromociones)
						if RegPro.codLocal==RegLo.codLocal and ((RegPro.estado).rstrip())=="aprobada" and RegPro.fechaDesdePromo>=fecha_desde and RegPro.fechaHastaPromo<=fecha_hasta:
							AlUso_promociones.seek(0)
							print("---------------------------")
							c=0
							while AlUso_promociones.tell()<TMaxUsoPromociones:
								RegUPro=pickle.load(AlUso_promociones)
								if RegUPro.codPromo==RegPro.codPromo and RegPro.fechaDesdePromo<=RegUPro.fechaUsoPromo and RegPro.fechaHastaPromo>=RegUPro.fechaUsoPromo:
									c=c+1
							if contLocal==0:
								print("Local nro ",RegLo.codLocal,"---Nombre:",RegLo.nombre)
								print("CÓDIGO PROMO/   TEXTO   /FECHA DESDE/FECHA HASTA/ CANT. USOS")
								print("------------------------------------------------------------")
							contLocal=contLocal+1
							print(RegPro.codPromo,end="/")
							print((RegPro.textoPromo).rstrip(),end="/")
							print(RegPro.fechaDesdePromo,end="/")
							print(RegPro.fechaHastaPromo,end="/")
							print("   ",c)
			else:
				print("No se usaron promociones")
	os.system("cls")

#Array utilizado para verificar un código de local y devolver el índice que contiene a ese codigo
def BuscarCod(codIng):
	global AlLocales,AfLocales,RegLo
	TmaxLo=os.path.getsize(AfLocales)
	AlLocales.seek(0)
	F=False
	while AlLocales.tell()<TmaxLo and F==False:
		pos=AlLocales.tell()
		RegLo=pickle.load(AlLocales)
		cod=pasarEntero(RegLo.codLocal)
		if cod==codIng:
			F=True
	if F==False:
		pos=-1
	return pos
def mostrarDiasSemanas(dias):
	print("[",end="")
	for i in range(7):
		if i==0:
			if dias[i]==1:
				print("D",end="/")
		if i==1:
			if dias[i]==1:
				print("L",end="/")
		if i==2:
			if dias[i]==1:
				print("M",end="/")
		if i==3:
			if dias[i]==1:
				print("X",end="/")
		if i==4:
			if dias[i]==1:
				print("J",end="/")
		if i==5:
			if dias[i]==1:
				print("V",end="/")
		if i==6:
			if dias[i]==1:
				print("S",end="/")
	print("]",end="")


#Array utilizado para modificar la información de los locales
def opcionb(pos):
	global AlLocales
	rta="H"
	x=locales()
	while rta!="E":
		AlLocales.seek(pos)
		x=pickle.load(AlLocales)
		print("El local cuyo código ingreso presenta la siguiente información: ")
		print("A)Nombre: ", x.nombre,"")
		print("B)Ubicación: ", x.ubicacion,"")
		print("C)Rubro:" , x.rubro,"")
		print("D)Codigo de usuario:", x.codUsuario,"")
		print("Código de local:", x.codLocal,"")
		print("E)Nada")
		print("¿Que desea modificar(A/B/C/D/E)?")
		rta=str(input())
		rta=rta.upper()
		if rta=="A":
			os.system("cls")
			print("Introduzca el nombre nuevo")
			nombre=input().lower()
			nombre=Largo50(nombre).ljust(50)
			I=validarNombre(nombre)
			if I==-1:
				x.nombre=nombre
				print("nombre cambiado con éxito")
			else:
				print("Ese nombre ya esta en uso, intente con otro")

			os.system("pause")
			
		if rta=="B":
			os.system("cls")
			ubi=str(input("Introduzca la nueva ubicación"))
			ubi=Largo50(ubi)
			x.ubicacion=ubi.ljust(50)
			print("ubicación cambiada con éxito")
			os.system("pause")
		if rta=="C":
			os.system("cls")
			RestarRubro(x.rubro)
			rubro=str(input("Introduzca el nuevo rubro del local: ")).lower()
			rubro=ValidarRubro(rubro)
			x.rubro=rubro.ljust(50)
			contRubro(rubro)
			print("se ha cambiado el rubro con éxito")
			os.system("pause")
		if rta=="D":
			os.system("cls")
			print("Introduzca el nuevo código de usuario del local: ")
			max=traerCmaxUsuario()
			codNuevo=val_ent(1,max)
			posUs=ValidarCodUsuario(codNuevo)
			if posUs==-1:
				print("El código introducido no pertenece a un usuario del tipo Dueño de local")
				print("Por favor, intente con otro")
				os.system("pause")
			else:
				x.codUsuario=codNuevo
				print("Se ha asignado el nuevo codigo de dueño de local con éxito")
				os.system("pause")
		AlLocales.seek(pos)
		x=formatLo(x)
		pickle.dump(x,AlLocales)
		AlLocales.flush()
		ordenLocales()
		OrdenaRubro()
		os.system("cls")

	MuestraLocales()
	MuestraRubro()
	os.system("pause")
def traerCmaxUsuario():
	global AlUsuario,RegU,AfUsuario
	TmaxU=os.path.getsize(AfUsuario)
	AlUsuario.seek(0)
	while AlUsuario.tell()<TmaxU:
		RegU=pickle.load(AlUsuario)
	cMax=pasarEntero(RegU.cod)
	return cMax
def RestarRubro(rubro):
	rubro=rubro.rstrip()
	global CR,RegRu
	for i in range(3):
		RegRu=CR[i]
		if RegRu.tipoRubro==rubro:
			RegRu.cRubro=RegRu.cRubro - 1
			CR[i]=RegRu

def registrarse():
	global RegU,TmaxUs,AfUsuario,AlUsuario
	TmaxUs=os.path.getsize(AfUsuario)
	AlUsuario.seek(0)
	while AlUsuario.tell()<TmaxUs:
		RegU=pickle.load(AlUsuario)
		codUs=pasarEntero(RegU.cod)
	codUs=codUs+1
	print("Ingrese el nombre del usuario a crear")
	usuarioNuevo=input()
	usuarioNuevo=Largo100(usuarioNuevo).ljust(100)
	pos=BuscarUsuario(usuarioNuevo)
	if pos !=-1:
		print("Ese usuario ya esta en uso, intentelo de nuevo con otro")
		os.system("pause")
		os.system("cls")
	else:
		print("Ingrese la clave del usuario: ")
		contra=stdiomask.getpass()
		contra=Largo8(contra)
		RegU.usuario=usuarioNuevo
		RegU.clave=contra
		RegU.tipoUsuario="cliente".ljust(13)
		RegU.cod=codUs
		os.system("pause")
		AlUsuario.seek(0,2)
		RegU=formatUs(RegU)
		pickle.dump(RegU,AlUsuario)
		AlUsuario.flush()
	os.system("cls")

def sesionIniciada():
	cont=0
	login=False
	llenarRubro()
	while cont<3 and login==False:
		os.system("cls")
		print("Ingrese su usuario: ")
		usIng=str(input()).ljust(100)
		conIng = stdiomask.getpass("Ingresa tu contraseña: ").ljust(8)
		cont=cont+1
		login=inSesion(usIng,conIng)
		tipo=credenciales(usIng)
		os.system("pause")
	if tipo=="administrador":
		menuAdmin(login)
	if tipo=="dueño":
		MenuDue(usIng)
	if tipo=="cliente":
		MenuCliente(usIng)

	if login==False:
		sesionFallida()
		os.system("pause")
		os.system("cls")

	print("Cerrando sesión")
	print("...")
	print("..")
	print(".")
op=-1
print(c.bold,c.cyan + "------BIENVENIDO------" + c.resetear,c.cyan)
while op!= 3:
	print("""
	1-Ingresar con usuario registrado
	2-Registrarse como cliente
	3-Salir
	   """)
	op=val_ent(1,3)
	if op==1:
		os.system("cls")
		sesionIniciada()
	if op==2:
		os.system("cls")
		registrarse()
	if op==3:
		os.system("cls")
		print(c.rojo + "Cerrando sistema")
		print("...")
		print("..")
		print(".")

AlUsuario.close()
AlLocales.close()
AlPromociones.close()
AlUso_promociones.close()
