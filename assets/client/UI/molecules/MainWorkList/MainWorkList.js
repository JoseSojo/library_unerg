import React from 'react';
import CardList from '../../compound/CardList/CardList';

export default function MainWorkList() {

    return (
        <section className='grid grid-col-1 lg:grid-cols-2 gap-3'>
            <CardList
                author={"José Sojo"}
                link={``}
                tagList={['software','informática','programación','ia','web']}
                title="Sistema de divulgación de trabajos de grado especiales, trabajos de grado y tesis doctorales"
            />
            <CardList
                author={"José Sojo"}
                link={``}
                tagList={['software','informática','programación','ia','web']}
                title="Sistema de divulgación de trabajos de grado especiales, trabajos de grado y tesis doctorales"
            />
        </section>
    );
}
