intervalId = setInterval(() => { ---1
      if (countdown > 1) {---2
        countdown -= 1---4
        eta.value = countdown----4
      } else if (countdown === 1) {---3
        setTimeout(() => {---5
          busArrived.value = true---5
        },100)---5
        clearInterval(intervalId)---5
      }
