import React from 'react';
import Subtitle from '../../atoms/Subtitle/Subtitle';
import Paragraph from '../../atoms/Paragraph/Paragraph';
import Button from '../../atoms/Button/Button';
import TagOrList from '../../atoms/Tags/TagOrList';

export default function CardList({ author, title, link, tagList }) {

    // modalLogic

    return (
        <div className={`flex-1 w-full relative bg-white shadow-md rounded-xl py-3 px-5 pb-5`} >
            <Subtitle customClass="text-xl font-light text-center" subtitle={author} />
            <Paragraph customClass="text-xs font-semibold text-gray-700" paragraph={title} />
            <div className='flex gap-3 p-3'>
                <Button 
                    click={()=>{}}
                    customClass='rounded-md flex-1 w-full px-3 py-1 text-center text-xs font-bold bg-[#2c698d] hover:bg-[#1d589f] py-2 text-white'
                    type='button'
                >
                    ver
                    <i className="bi bi-arrow-right"></i> 
                </Button>
                <div className='flex-[3] flex gap-2 flex-wrap'>
                    <TagOrList
                        list={tagList}
                        customClass=''
                    />
                </div>
            </div>
        </div>
    );
}
