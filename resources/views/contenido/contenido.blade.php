    @extends('principal')
    @section('contenido')

    @if(Auth::check())
            @if (Auth::user()->idrol == 1)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>

            <template v-if="menu==1">            
                <estudiante :ruta="ruta"></estudiante>
            </template>

            <template v-if="menu==2">
                <curso :ruta="ruta"></curso>
            </template>

            <template v-if="menu==3">
                <docente :ruta="ruta"></docente>
            </template>

            <template v-if="menu==4">
                <competencia :ruta="ruta"></competencia>
            </template>

            <template v-if="menu==10">
                <nota :ruta="ruta"></nota>
            </template>

            <template v-if="menu==11">
                <registro :ruta="ruta"></registro>
            </template>
            <template v-if="menu==12">
                    <registroadmin :ruta="ruta"></registroadmin>
            </template>
            <template v-if="menu==13">
                    <notaprimero :ruta="ruta"></notaprimero>
            </template>
            <template v-if="menu==14">
                    <registroprimero :ruta="ruta"></registroprimero>
            </template>
            <template v-if="menu==5">
                    <notaactitudinal :ruta="ruta"></notaactitudinal>
            </template>
            <template v-if="menu==7">
                <user :ruta="ruta"></user>
            </template>

            <template v-if="menu==8">
                <rol :ruta="ruta"></rol>
            </template>
            <template v-if="menu==19">
                <registroadminprimero :ruta="ruta"></registroadminprimero>
        </template>

            <template v-if="menu==15">
                <ayuda></ayuda>
            </template>

            <template v-if="menu==16">
                <acerca></acerca>
            </template>
            
            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0">
                    <dashboard :ruta="ruta"></dashboard>
                </template>
    
                <template v-if="menu==1">            
                    <estudiante :ruta="ruta"></estudiante>
                </template>
    
                <template v-if="menu==2">
                    <curso :ruta="ruta"></curso>
                </template>
    
                <template v-if="menu==3">
                    <docente :ruta="ruta"></docente>
                </template>
    
                <template v-if="menu==4">
                    <competencia :ruta="ruta"></competencia>
                </template>
    
                <template v-if="menu==10">
                    <nota :ruta="ruta"></nota>
                </template>
    
                <template v-if="menu==11">
                    <registro :ruta="ruta"></registro>
                </template>
                <template v-if="menu==13">
                        <notaprimero :ruta="ruta"></notaprimero>
                </template>
                <template v-if="menu==14">
                        <registroprimero :ruta="ruta"></registroprimero>
                </template>
                <template v-if="menu==19">
                    <registroadminprimero :ruta="ruta"></registroadminprimero>
            </template>
                <template v-if="menu==7">
                    <user :ruta="ruta"></user>
                </template>
    
                <template v-if="menu==8">
                    <rol :ruta="ruta"></rol>
                </template>
    
    
                <template v-if="menu==15">
                    <ayuda></ayuda>
                </template>
    
                <template v-if="menu==16">
                    <acerca></acerca>
                </template>
            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0">
                    <dashboard :ruta="ruta"></dashboard>
                </template>
    
                <template v-if="menu==1">            
                    <estudiante :ruta="ruta"></estudiante>
                </template>
    
                <template v-if="menu==2">
                    <curso :ruta="ruta"></curso>
                </template>
    
                <template v-if="menu==3">
                    <docente :ruta="ruta"></docente>
                </template>
    
                <template v-if="menu==4">
                    <competencia :ruta="ruta"></competencia>
                </template>
    
                <template v-if="menu==10">
                    <nota :ruta="ruta"></nota>
                </template>
                <template v-if="menu==13">
                        <notaprimero :ruta="ruta"></notaprimero>
                </template>
                <template v-if="menu==14">
                        <registroprimero :ruta="ruta"></registroprimero>
                </template>
                <template v-if="menu==11">
                    <registro :ruta="ruta"></registro>
                </template>
                <template v-if="menu==5">
                        <notaactitudinal :ruta="ruta"></notaactitudinal>
                </template>
                <template v-if="menu==6">
                        <registroactitudinal :ruta="ruta"></registroactitudinal>
                </template>
                <template v-if="menu==7">
                    <user :ruta="ruta"></user>
                </template>
    
                <template v-if="menu==8">
                    <rol :ruta="ruta"></rol>
                </template>
    
    
                <template v-if="menu==15">
                    <ayuda></ayuda>
                </template>
    
                <template v-if="menu==16">
                    <acerca></acerca>
                </template>
            @else

            @endif

    @endif
       
        
    @endsection