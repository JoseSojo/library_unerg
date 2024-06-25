import React from 'react';
import CardRelease from '../../compound/CardRelease/CardRelease';
import Subtitle from '../../atoms/Subtitle/Subtitle';

export default function MainWorkRelease() {

    
    return (
        <>
            <Subtitle customClass='text-2xl font-light text-gray-800' subtitle='Trabajos destacados' />
            <section className='w-full gap-4 p-5 lg:px-8 flex flex-col lg:flex-row lg:flex-wrap'>
                <CardRelease
                    author='José Sojo'
                    link=''
                    tagList={['software','informática','programación','ia','web']}
                    title='Tibajo de grado con un tema X enfocado a detalles del trabajo'
                />
                <CardRelease
                    author='Kharla Hernández'
                    link=''
                    tagList={['enfermería','diagnostico','discapacidad','educación','equipo']}
                    title='Tibajo de grado con un tema X enfocado a detalles del trabajo mas texto lontext'
                />
                <CardRelease
                    author='José Sojo'
                    link=''
                    tagList={['software','informática','programación','ia','web']}
                    title='Tibajo de grado con un tema X enfocado a detalles del trabajo'
                />
            </section>
        </>
    );
}
