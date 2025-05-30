# vulnerabilities_detection_wp

=== WP Security Scanner para Entornos Universitarios ===
Contributors: suarez_emiliano
Tags: seguridad, wordpress, vulnerabilidades, cwe, escaneo, universidades
Requires at least: 5.8
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Herramienta de análisis automático de seguridad para instalaciones WordPress, orientada a entornos universitarios. Identifica vulnerabilidades en componentes activos y genera informes con recomendaciones basadas en CWE.

== Description ==

**Introducción**

WordPress es ampliamente utilizado en universidades para desarrollar sitios institucionales, portales académicos y blogs docentes. Sin embargo, su flexibilidad y extensibilidad conllevan riesgos si no se gestionan adecuadamente los plugins, temas y configuraciones.

Este plugin surge como respuesta a la necesidad de contar con una herramienta que facilite el monitoreo de seguridad de estas plataformas, siguiendo buenas prácticas y estándares de la industria.

**Características principales:**
- Escaneo automático de componentes activos (plugins, temas y núcleo).
- Consulta de base de datos de vulnerabilidades.
- Correlación con antipatrones de seguridad definidos por CWE.
- Visualización de resultados y generación de reportes.
- Recomendaciones prácticas para mitigar riesgos.

**Orientado a:**  
Administradores de WordPress en entornos educativos, técnicos en informática universitaria, docentes y estudiantes en prácticas profesionales relacionadas a ciberseguridad y desarrollo web.

== Installation ==

1. Sube la carpeta del plugin al directorio `/wp-content/plugins/`.
2. Activa el plugin desde el menú "Plugins" de WordPress.
3. Accede al panel de administración del plugin desde el menú lateral para configurar y visualizar los resultados del escaneo.

== Frequently Asked Questions ==

= ¿Qué tipo de vulnerabilidades detecta el plugin? =

Se basa en una base de datos confiable de vulnerabilidades públicas, y relaciona cada hallazgo con los antipatrones de seguridad de CWE.

= ¿Es necesario tener conocimientos técnicos para usarlo? =

No. El panel está diseñado para ofrecer una interfaz simple con visualizaciones claras y recomendaciones accesibles para cualquier administrador.

= ¿Requiere conexión a internet? =

Sí, ya que consulta una base de datos externa para identificar vulnerabilidades.

== Screenshots ==

1. Página principal del panel de escaneo
2. Vista de un informe con recomendaciones
3. Gráficos con resumen de vulnerabilidades por tipo

== Changelog ==

= 1.0.0 =
* Primera versión funcional del plugin.
* Escaneo de componentes activos.
* Integración con API de vulnerabilidades.
* Generación de informes automáticos.

== Upgrade Notice ==

= 1.0.0 =
Versión inicial. Incluye todas las funcionalidades básicas del sistema de escaneo y reporte.

== Credits ==

Desarrollado como parte de una práctica profesional en el marco de un proyecto académico.

== License ==

Este plugin es software libre y se distribuye bajo los términos de la GNU General Public License v2 o posterior.
