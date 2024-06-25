import React from 'react';
import MainSlideCategory from '../../molecules/MainSlideCategory/MainSlideCategory';
import MainWorkRelease from '../../molecules/MainWorkRelease/MainWorkRelease';
import MainWorkRecent from '../../molecules/MainWorkRecent/MainWorkRecent';
import MainWorkList from '../../molecules/MainWorkList/MainWorkList';
import LOGO from '../../../../images/logo.png';
import SearchMain from '../../molecules/SearchMain/SearchMain';
import CardCategory from '../../compound/CardCategory/CardCategory';

export default function Main() {

    return (
        <div className="flex flex-col flex-1">
            <div className="flex gap-5 justify-center px-3 lg:px-11">
                <CardCategory count={240} title={`Tesis doctoral`} url={`#`} />
                <CardCategory count={340} title={`Trabajo especial de grado`} url={`#`} />
                <CardCategory count={455} title={`Trabajo de grado`} url={`#`} />
            </div>
            <div className="grid place-items-center mt-10">
                <SearchMain LOGO={LOGO} />      
            </div>
            <main>
                <div className="py-6">
                    <div className="px-4 mx-auto max-w-7xl sm:px-6 md:px-8">
                        
                    </div>
                </div>
            </main>
        </div>
    );
}
