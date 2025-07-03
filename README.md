```javascript
intervalId = setInterval(() => {                              //--1
      eta.value = Math.floor(Math.random() * 6) + 10          //--2 
      if(eta.value > expectedETA + 5)                         //--3
      {
        delayed.value = true                                  //--4
      }
      else {
        delayed.value = false                                 //--5
      }
      showNotice.value = delayed.value                        //--6
