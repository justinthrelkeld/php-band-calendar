# Roadmap for Future Development

V1 - now

V2 
- update to grab address from within `<address>` tag. 
- Stop using PHP to JSON hack.
  - This would be accomplished by calling `$(thisEvent > address).text();` in jQuery. 
- Separate JS from PHP. 
- Make the event details viewer function regardless of how the calendar list is built on a page.

Ideal structure:

```
  <someElement #eventList>
    <someElement class="event">
      <header>
        <h2>Event Title</h2>
        <time datetime="2012-02-17">
          <span class="date">February 17, 2012</span>
          <span class="time">7:00pm</span>
        </time>
        <address>Address</address>
      </header>
      <p>Description</p>
    </someElement>
  </someElement>
```
