import React from 'react';

export default function Content({ site, menu, title, content, type }) {
  return (
    <>
      <h2>{title}</h2>
      <div dangerouslySetInnerHTML={{ __html: content }} />
      <p>Type: {type}</p>
    </>
  );
}