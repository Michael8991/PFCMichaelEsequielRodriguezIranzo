# Proyecto de Gestión de Clientes, Servicios, Presupuestos, Proyectos y Facturas

## Descripción

Este proyecto es una aplicación integral para la gestión de clientes, servicios, presupuestos, proyectos y facturas, desarrollada utilizando la metodología ágil Scrum. La aplicación permite la administración eficiente de diferentes entidades mediante un conjunto de funcionalidades que abarcan desde la creación hasta la eliminación de registros, incluyendo la visualización detallada y la integración con otros módulos.

## Características

### Gestión de Clientes
La gestión de clientes incluye funcionalidades para la creación, actualización, eliminación y visualización de clientes. Cada cliente puede tener información detallada, incluyendo proyectos asociados y documentos relacionados.

#### Creación de Clientes
- **Desarrollar función para crear nuevos clientes**
  - Implementación del formulario de creación de clientes
  - Validación de los datos del cliente
  - Almacenamiento de datos del cliente en la base de datos

#### Actualización de Clientes
- **Desarrollar función para actualizar información del cliente**
  - Implementación del formulario de actualización de clientes
  - Validación de los cambios realizados
  - Actualización de datos del cliente en la base de datos

#### Eliminación de Clientes
- **Desarrollar función para eliminar clientes**
  - Confirmación de eliminación por parte del usuario
  - Eliminación de datos del cliente en la base de datos
  - Manejo de dependencias y relaciones con otros módulos

#### Visualización de Clientes
- **Desarrollar función para visualizar lista de clientes**
  - Implementación de la interfaz de visualización de clientes
  - Filtros y búsqueda de clientes por diferentes criterios (nombre, fecha, estado, etc.)

- **Visualización detallada de clientes**
  - Mostrar detalles completos de un cliente seleccionado (información general, proyectos asociados, etc.)
  - Integración con otros módulos para mostrar presupuestos, facturas y documentos relacionados

### Gestión de Servicios
La gestión de servicios proporciona funcionalidades para manejar los servicios ofrecidos por la empresa, incluyendo su creación, actualización, eliminación y visualización.

#### Creación de Servicios
- **Desarrollar función para crear nuevos servicios**
  - Implementación del formulario de creación de servicios
  - Validación de los datos del servicio
  - Almacenamiento de datos del servicio en la base de datos

#### Actualización de Servicios
- **Desarrollar función para actualizar información del servicio**
  - Implementación del formulario de actualización de servicios
  - Validación de los cambios realizados
  - Actualización de datos del servicio en la base de datos

#### Eliminación de Servicios
- **Desarrollar función para eliminar servicios**
  - Confirmación de eliminación por parte del usuario
  - Eliminación de datos del servicio en la base de datos
  - Manejo de dependencias y relaciones con otros módulos

#### Visualización de Servicios
- **Desarrollar función para visualizar lista de servicios**
  - Implementación de la interfaz de visualización de servicios
  - Filtros y búsqueda de servicios por diferentes criterios (nombre, fecha, categoría, etc.)

- **Visualización detallada de servicios**
  - Mostrar detalles completos de un servicio seleccionado (información general, proyectos asociados, etc.)
  - Integración con otros módulos para mostrar presupuestos, facturas y documentos relacionados

### Gestión de Presupuestos
La gestión de presupuestos permite la generación, actualización, eliminación y visualización de presupuestos, así como la integración con otros módulos del sistema.

#### Generación de Presupuestos
- **Desarrollar función para generar presupuestos**
  - Implementación del formulario de creación de presupuestos
  - Selección de servicios y productos a incluir en el presupuesto
  - Cálculo automático de costos y totales
  - Almacenamiento del presupuesto en la base de datos

#### Actualización de Presupuestos
- **Desarrollar función para actualizar presupuestos existentes**
  - Implementación del formulario de actualización de presupuestos
  - Validación de los cambios realizados
  - Actualización de datos del presupuesto en la base de datos

#### Eliminación de Presupuestos
- **Desarrollar función para eliminar presupuestos**
  - Confirmación de eliminación por parte del usuario
  - Eliminación de datos del presupuesto en la base de datos
  - Manejo de dependencias y relaciones con otros módulos

#### Visualización de Presupuestos
- **Desarrollar función para visualizar lista de presupuestos**
  - Implementación de la interfaz de visualización de presupuestos
  - Filtros y búsqueda de presupuestos por diferentes criterios (fecha, cliente, estado, etc.)

- **Visualización detallada de presupuestos**
  - Mostrar detalles completos de un presupuesto seleccionado (información general, servicios/productos incluidos, etc.)
  - Integración con otros módulos para mostrar facturas y documentos relacionados

### Gestión de Proyectos
La gestión de proyectos abarca la creación, actualización, eliminación y visualización de proyectos, permitiendo una administración completa y detallada de cada proyecto.

#### Creación de Proyectos
- **Desarrollar función para crear nuevos proyectos**
  - Definición de los campos necesarios para la creación del proyecto (nombre, descripción, fechas, etc.)
  - Implementación del formulario de creación de proyectos
  - Validación de datos del formulario
  - Almacenamiento de datos del proyecto en la base de datos

- **Integrar creación de proyectos con clientes asignados**

#### Actualización de Proyectos
- **Desarrollar función para actualizar información del proyecto**
  - Implementación del formulario de actualización de proyectos
  - Validación de los cambios realizados
  - Actualización de datos del proyecto en la base de datos

#### Eliminación de Proyectos
- **Desarrollar función para eliminar proyectos**
  - Confirmación de eliminación por parte del usuario
  - Eliminación de datos del proyecto en la base de datos
  - Manejo de dependencias y relaciones con otros módulos

#### Visualización de Proyectos
- **Desarrollar función para visualizar lista de proyectos**
  - Implementación de la interfaz de visualización de proyectos
  - Filtros y búsqueda de proyectos por diferentes criterios (fecha, estado, responsable, etc.)

- **Visualización detallada de proyectos**
  - Mostrar detalles completos de un proyecto seleccionado (información general, usuarios asignados, etc.)
  - Integración con otros módulos para mostrar presupuestos, facturas, y documentos relacionados

### Gestión de Facturas
La gestión de facturas cubre la generación, actualización, eliminación y visualización de facturas, facilitando el seguimiento y control de las mismas.

#### Generación de Facturas
- **Desarrollar función para generar facturas**
  - Implementación del formulario de creación de facturas
  - Selección de presupuestos, servicios y productos a incluir en la factura
  - Cálculo automático de totales y impuestos
  - Almacenamiento de la factura en la base de datos

#### Actualización de Facturas
- **Desarrollar función para actualizar facturas existentes**
  - Implementación del formulario de actualización de facturas
  - Validación de los cambios realizados
  - Actualización de datos de la factura en la base de datos

#### Eliminación de Facturas
- **Desarrollar función para eliminar facturas**
  - Confirmación de eliminación por parte del usuario
  - Eliminación de datos de la factura en la base de datos
  - Manejo de dependencias y relaciones con otros módulos

#### Visualización de Facturas
- **Desarrollar función para visualizar lista de facturas**
  - Implementación de la interfaz de visualización de facturas
  - Filtros y búsqueda de facturas por diferentes criterios (fecha, cliente, estado, etc.)

- **Visualización detallada de facturas**
  - Mostrar detalles completos de una factura seleccionada (información general, servicios/productos incluidos, etc.)
  - Integración con otros módulos para mostrar presupuestos y documentos relacionados

## Autores

- **Michael Eseaquiel Rodríguez Iranzo** - [GitHub](https://github.com/Michael8991o) - Desarrollador Principal


