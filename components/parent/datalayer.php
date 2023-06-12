<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.dataLayer = window.dataLayer || [];

        if(document.querySelector('body').classList.contains('single-post')){
            const data = get_dataLayerData();
            dataLayer.push(data);
        }
    });

    function get_dataLayerData(){
        let data = {
            'url': window.location.href
        }

        const pa_autor = document.querySelector('meta[name="pa_autor"]')?.content;
        const pa_sedes_regionais = document.querySelector('meta[name="pa_sedes_regionais"]')?.content;
        const pa_sedes_proprietarias = document.querySelector('meta[name="pa_sedes_proprietarias"]')?.content;
        const pa_editoriais = document.querySelector('meta[name="pa_editoriais"]')?.content;
        const pa_departamento = document.querySelector('meta[name="pa_departamento"]')?.content;
        const pa_projeto = document.querySelector('meta[name="pa_projeto"]')?.content;
        const pa_regiao = document.querySelector('meta[name="pa_regiao"]')?.content;
        const pa_formato_post = document.querySelector('meta[name="pa_formato_post"]')?.content;

        pa_autor ? data['pa_autor'] = pa_autor : '';
        pa_sedes_regionais ? data['pa_sedes_regionais'] = pa_sedes_regionais : '';
        pa_sedes_proprietarias ? data['pa_sedes_proprietarias'] = pa_sedes_proprietarias : '';
        pa_editoriais ? data['pa_editoriais'] = pa_editoriais : '';
        pa_departamento ? data['pa_departamento'] = pa_departamento : '';
        pa_projeto ? data['pa_projeto'] = pa_projeto : '';
        pa_regiao ? data['pa_regiao'] = pa_regiao : '';
        pa_formato_post ? data['pa_formato_post'] = pa_formato_post : '';

        return data;
    }
</script>