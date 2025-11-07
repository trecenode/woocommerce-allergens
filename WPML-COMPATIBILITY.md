# Compatibilidad WPML - Allergens for WooCommerce

## Problema Resuelto

Este plugin ahora incluye compatibilidad completa con WPML. Ya no necesitas volver a seleccionar manualmente los alérgenos cuando traduces un producto - se copiarán automáticamente.

## Qué se ha implementado:

### 1. Configuración automática de campos personalizados
- Los campos de alérgenos se configuran automáticamente como "Copy" en WPML
- Incluye tanto los campos del producto principal como las variaciones
- Se ejecuta automáticamente cuando el plugin detecta WPML

### 2. Copia automática de datos
- Los alérgenos se copian automáticamente cuando se crea una traducción
- Funciona tanto para productos simples como variables
- Las variaciones mantienen sus alérgenos en todas las traducciones

### 3. Sincronización inteligente
- Si una traducción no tiene alérgenos configurados, se copian del producto original
- Los datos se sincronizan cuando guardas un producto traducido
- Evita sobrescribir configuraciones manuales

## Cómo funciona:

### Para productos simples:
1. Configura los alérgenos en el producto original
2. Crea la traducción en WPML
3. Los alérgenos se copian automáticamente

### Para productos variables:
1. Configura los alérgenos en las variaciones del producto original
2. Crea la traducción del producto variable
3. Las variaciones traducidas heredan automáticamente los alérgenos

## Archivos modificados:

- `allergens-woocommerce.php` - Funciones de compatibilidad WPML añadidas
- `wpml-config.xml` - Configuración automática de campos WPML

## Funciones añadidas:

- `treceafw_wpml_compatibility()` - Inicializa la compatibilidad
- `treceafw_copy_allergens_to_translation()` - Copia alérgenos a traducciones
- `treceafw_copy_allergens_on_duplicate()` - Copia al duplicar productos
- `treceafw_configure_wpml_custom_fields()` - Configura campos automáticamente
- `treceafw_sync_allergens_on_save()` - Sincroniza al guardar

## Requisitos:

- WPML (WooCommerce Multilingual recomendado)
- WooCommerce
- WordPress 4.0+

## Notas importantes:

- Los alérgenos no cambian con el idioma (se copian tal como están)
- Si necesitas alérgenos diferentes por idioma, puedes editarlos manualmente en cada traducción
- El plugin detecta automáticamente si WPML está instalado y activo