import React from 'react';
import Subtitle from '../../atoms/Subtitle/Subtitle';
import Paragraph from '../../atoms/Paragraph/Paragraph';
import Button from '../../atoms/Button/Button';
import TagOrList from '../../atoms/Tags/TagOrList';

export default function CardRelease({ author, title, link, tagList }) {

    // modalLogic

    return (
        <div className={`flex-1 max-w-[350px] min-w-[300px] flex flex-col justify-between relative bg-white shadow-md rounded-xl py-3 px-5 pb-5`} >
            <Subtitle customClass='text-2xl text-gray-900 font-serif text-center' subtitle={author} />
            <Paragraph customClass='text-sm text-gray-700 font-semibold text-center mt-4' paragraph={title} />

            <div className='flex gap-2 flex-wrap mt-4'>
                <TagOrList 
                    list={tagList}
                    customClass={`px-3 py-1 bg-gray-400 text-gray-800 font-bold text-xs rounded-[20px]`}
                />
            </div> 

            <Button 
                click={()=>{}}
                customClass='absolute bottom-0 right-0 rounded-br-xl rounded-tl-xl px-3 py-1 text-center text-xs font-bold bg-[#2c698d] hover:bg-[#1d589f] hover:-translate-x-2 hover:scale-x-125 duration-200 py-2 text-white'
                type='button'
            >
                ver
                <i className="bi bi-arrow-right"></i> 
            </Button>
        </div>
    );
}
